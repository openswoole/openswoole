<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    public const WRITE_SIGNS = ['w', 'a', 'x', 'c', '+'];

    public const READ_SIGNS = ['r', '+'];

    private $resource;

    public function __construct($resource, $mode = 'rb')
    {
        $this->attach($resource, $mode);
    }

    public function __destruct()
    {
        $this->close();
    }

    public function __toString(): string
    {
        if (!$this->isReadable()) {
            return '';
        }

        try {
            if ($this->isSeekable()) {
                $this->seek(0);
            }

            return $this->getContents();
        } catch (\RuntimeException $e) {
            return '';
        }
    }

    public function read($length): string
    {
        if (!$this->isReadable()) {
            throw new \RuntimeException('The stream is not readable');
        }

        $data = fread($this->resource, $length);

        if ($data === false) {
            throw new \RuntimeException("couldn't read the resource!");
        }

        return $data;
    }

    public function close(): void
    {
        if (!$this->resource) {
            return;
        }

        $res = $this->detach();
        fclose($res);
    }

    public function detach()
    {
        $resource       = $this->resource;
        $this->resource = null;
        return $resource;
    }

    public function eof(): bool
    {
        return !$this->resource
            ? true
            : feof($this->resource);
    }

    public function isReadable(): bool
    {
        $mode = $this->getMetadata('mode');

        if ($mode === null) {
            return false;
        }

        $res = array_filter(static::READ_SIGNS, function ($v) use ($mode) {
            return strstr($mode, $v) !== false;
        });

        return count($res) > 0;
    }

    public function isWritable(): bool
    {
        $mode = $this->getMetadata('mode');

        if ($mode === null) {
            return false;
        }

        $res = array_filter(static::WRITE_SIGNS, function ($v) use ($mode) {
            return strstr($mode, $v) !== false;
        });

        return count($res) > 0;
    }

    public function isSeekable(): bool
    {
        $seekable = $this->getMetadata('seekable');

        if ($seekable === null) {
            return false;
        }

        return $seekable;
    }

    public function getMetadata($key = null)
    {
        if (!$this->resource) {
            return null;
        }

        $md = stream_get_meta_data($this->resource);

        if ($key === null) {
            return $md;
        }

        return array_key_exists($key, $md) ? $md[$key] : null;
    }

    public function tell(): int
    {
        if (!$this->resource) {
            throw new \RuntimeException('No resource available');
        }

        $position = ftell($this->resource);

        if ($position === false) {
            throw new \RuntimeException('No position found');
        }
        return $position;
    }

    public function getSize(): ?int
    {
        if (!$this->resource) {
            return null;
        }

        $info = fstat($this->resource);

        return $info !== false
            ? $info['size']
            : null;
    }

    public function getContents(): string
    {
        if (!$this->isReadable()) {
            throw new \RuntimeException('The stream is not readable');
        }

        $content = stream_get_contents($this->resource);

        if ($content === false) {
            throw new \RuntimeException('Errors occurred when reading the resource');
        }

        return $content;
    }

    public function rewind(): void
    {
        $this->seek(0);
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
        if (!$this->isSeekable()) {
            throw new \RuntimeException('The stream is not seekable');
        }

        $done = fseek($this->resource, $offset, $whence);

        if ($done === -1) {
            throw new \RuntimeException('Seeking error');
        }
    }

    public function attach($resource, string $mode)
    {
        if (is_resource($resource)) {
            if (get_resource_type($resource) !== 'stream') {
                throw new \InvalidArgumentException("the type of a resource must be 'stream'");
            }
            $this->resource = $resource;
            return;
        }

        $err = null;

        set_error_handler(function ($errNo, $errStr) use (&$err) {
            $err = $errStr;
        }, E_WARNING);

        $handle = fopen($resource, $mode);

        restore_error_handler();

        if ($err !== null) {
            throw new \InvalidArgumentException(sprintf("Cannot open '%s', Error: %s", $resource, $err));
        }

        $this->resource = $handle;
    }

    public function write($string): int
    {
        if (!$this->isWritable()) {
            throw new \RuntimeException('The stream is not writable');
        }

        $written = fwrite($this->resource, $string);

        if ($written === false) {
            throw new \RuntimeException("couldn't write the string into the stream!");
        }

        return $written;
    }

    public static function streamFor($resource = '')
    {
        if (is_scalar($resource)) {
            $stream = fopen('php://memory', 'r+');
            if ($resource !== '') {
                fwrite($stream, (string) $resource);
                fseek($stream, 0);
            }
            return new Stream($stream);
        }
    }

    public static function createStreamFromFile(string $filename, string $mode = 'r')
    {
        if ($mode === '' || !preg_match('/^[rwaxce]{1}[bt]{0,1}[+]{0,1}+$/', $mode)) {
            throw new InvalidArgumentException(sprintf('Invalid file opening mode "%s"', $mode));
        }

        $resource = @fopen($filename, $mode);

        if (!is_resource($resource)) {
            throw new RuntimeException(sprintf('Unable to open file at "%s"', $filename));
        }

        return new Stream($resource);
    }
}

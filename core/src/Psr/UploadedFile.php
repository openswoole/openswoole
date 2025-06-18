<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;

class UploadedFile implements UploadedFileInterface
{
    private $error;

    private $file;

    private $size;

    private $stream;

    private $isMoved = false;

    private $clientFilename;

    private $clientMediaType;

    public function __construct($fileOrResourceOrStream, int $size, int $errorStatus, ?string $clientFilename = null, ?string $clientMediaType = null)
    {
        $this->size            = $size;
        $this->error           = $errorStatus;
        $this->clientFilename  = $clientFilename;
        $this->clientMediaType = $clientMediaType;
        $this->apply($fileOrResourceOrStream);
    }

    public function getClientFilename(): ?string
    {
        return $this->clientFilename;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getClientMediaType(): ?string
    {
        return $this->clientMediaType;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getStream()
    {
        if ($this->isMoved) {
            throw new RuntimeException('File moved.');
        }

        if ($this->stream !== null) {
            return $this->stream;
        }

        $this->stream = new Stream($this->file);
        return $this->stream;
    }

    public function moveTo($targetPath): void
    {
        if ($this->stream !== null) {
            $from = $this->getStream();
            $to   = new Stream($targetPath, 'wb');

            $from->rewind();

            while (!$from->eof()) {
                $to->write($from->read(4096));
            }
            $this->isMoved = true;
        }

        if ($this->file !== null) {
            $this->isMoved = rename($this->file, $targetPath);
        }

        if ($this->isMoved === false) {
            throw new RuntimeException('Can not move to ' . $targetPath);
        }
    }

    private function apply($fileOrResourceOrStream): void
    {
        if ($fileOrResourceOrStream !== null) {
            $this->stream = $fileOrResourceOrStream;
            return;
        }

        if (is_resource($fileOrResourceOrStream)) {
            $this->stream = new Stream($fileOrResourceOrStream);
            return;
        }

        $this->file = $fileOrResourceOrStream;
    }
}

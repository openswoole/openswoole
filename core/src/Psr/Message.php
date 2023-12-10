<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use InvalidArgumentException;

class Message
{
    public $headers = [];

    protected $protocolVersion = '1.1';

    protected $stream;

    public function __construct($stream = null)
    {
        if ($stream === null) {
            $stream = new Stream('php://memory', 'wb+');
        }

        $this->withBody($stream);
    }

    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    public function withProtocolVersion($version)
    {
        $message                  = clone $this;
        $message->protocolVersion = $version;
        return $message;
    }

    public function getHeaders()
    {
        $headers = [];
        foreach ($this->headers as $header => $line) {
            $headers[$header] = is_array($line) ? $line : [$line];
        }
        return $headers;
    }

    public function hasHeader($name)
    {
        return isset($this->headers[strtolower($name)]);
    }

    public function getHeader($name)
    {
        return $this->hasHeader($name) ? $this->headers[strtolower($name)] : [];
    }

    public function getHeaderLine($name)
    {
        $value = $this->getHeader($name);

        if (empty($value)) {
            return '';
        }

        return is_array($value) ? implode(',', $value) : $value;
    }

    public function withHeader($name, $value)
    {
        if (!is_string($name) || !is_string($value) && !is_array($value) || $name === '' || $value !== '' && empty($value)) {
            throw new InvalidArgumentException('Header is not validate.');
        }
        $message = clone $this;

        if (is_array($value)) {
            $message->headers[strtolower($name)] = $value;
        } else {
            $message->headers[strtolower($name)] = [$value];
        }

        return $message;
    }

    public function withHeaders(array $headers)
    {
        $message = clone $this;
        foreach ($headers as $key => $header) {
            if (is_array($header)) {
                foreach ($header as $item) {
                    $message = $message->withAddedHeader($key, $item);
                }
            } else {
                $message = $message->withHeader($key, $header);
            }
        }

        return $message;
    }

    public function withAddedHeader($name, $value)
    {
        if (!is_string($name) || !is_string($value) && !is_array($value) || empty($name) || $value !== '' && $value !== '0' && empty($value)) {
            throw new InvalidArgumentException('Header is not validate.');
        }
        $message = clone $this;
        if (is_array($value)) {
            foreach ($value as $item) {
                $message->headers[strtolower($name)][] = $item;
            }
        } else {
            $message->headers[strtolower($name)][] = $value;
        }

        return $message;
    }

    public function withoutHeader($name)
    {
        $name = strtolower($name);

        if (!$this->hasHeader($name)) {
            return $this;
        }

        unset($this->headers[$name]);

        return $this;
    }

    public function getBody()
    {
        return $this->stream;
    }

    public function withBody($stream)
    {
        $message         = clone $this;
        $message->stream = $stream;
        return $message;
    }

    protected function setHeaders(array $headers): void
    {
        $this->headers = $this->withHeaders($headers)
            ->getHeaders()
        ;
    }
}

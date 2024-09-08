<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use InvalidArgumentException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{
    public array $headers = [];

    protected string $protocolVersion = '1.1';

    protected StreamInterface $body;

    public function __construct(?StreamInterface $stream = null)
    {
        if ($stream === null) {
            $stream = new Stream('php://memory', 'wb+');
        }
        $this->body = $stream;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function withProtocolVersion(string $version): MessageInterface
    {
        $message                  = clone $this;
        $message->protocolVersion = $version;
        return $message;
    }

    public function getHeaders(): array
    {
        $headers = [];
        foreach ($this->headers as $header => $line) {
            $headers[$header] = is_array($line) ? $line : [$line];
        }
        return $headers;
    }

    public function withHeaders(array $headers): MessageInterface
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

    public function withAddedHeader(string $name, $value): MessageInterface
    {
        if (!is_string($value) && !is_array($value) || empty($name) || $value !== '' && $value !== '0' && empty($value)) {
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

    public function withHeader(string $name, $value): MessageInterface
    {
        if (!is_string($value) && !is_array($value) || $name === '' || $value !== '' && empty($value)) {
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

    public function getHeaderLine(string $name): string
    {
        $value = $this->getHeader($name);

        return implode(',', $value);
    }

    public function getHeader(string $name): array
    {
        return $this->hasHeader($name) ? $this->headers[strtolower($name)] : [];
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    public function withoutHeader(string $name): MessageInterface
    {
        $name = strtolower($name);

        if (!$this->hasHeader($name)) {
            return $this;
        }

        unset($this->headers[$name]);

        return $this;
    }

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        $message       = clone $this;
        $message->body = $body;
        return $message;
    }

    protected function setHeaders(array $headers): void
    {
        $this->headers = $this->withHeaders($headers)
            ->getHeaders()
        ;
    }
}

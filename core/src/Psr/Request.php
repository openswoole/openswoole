<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    private ?string $method;

    private UriInterface $uri;

    private ?string $requestTarget;

    public function __construct($uri, ?string $method = null, $body = null, array $headers = [], string $protocolVersion = '1.1')
    {
        $this->uri             = is_string($uri) ? new Uri($uri) : $uri;
        $this->method          = $method;
        $this->headers         = $headers;
        $this->protocolVersion = $protocolVersion;
        if ($body === null) {
            $stream = new Stream('php://memory', 'wb+');
            $this->withBody($stream);
        } elseif (is_resource($body)) {
            $this->body = new Stream($body);
        } else {
            $this->body = Stream::streamFor($body);
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod($method): RequestInterface
    {
        if (!is_string($method)) {
            throw new InvalidArgumentException('Method is not validate.');
        }
        $request         = clone $this;
        $request->method = $method;
        return $request;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function withUri($uri, $preserveHost = false): RequestInterface
    {
        if ($uri === $this->uri) {
            return $this;
        }

        $request = clone $this;

        $request->uri = $uri;

        if ($preserveHost && $this->hasHeader('Host')) {
            return $request;
        }

        $uriHost = $uri->getHost();

        if (empty($uriHost)) {
            return $request;
        }

        if ($uri->getPort()) {
            $uriHost .= ':' . $uri->getPort();
        }

        return $request->withHeader('Host', $uriHost);
    }

    public function getRequestTarget(): string
    {
        if ($this->requestTarget !== null) {
            return $this->requestTarget;
        }

        $target = $this->uri->getPath();
        if (!empty($query = $this->uri->getQuery())) {
            $target .= '?' . $query;
        }

        if (empty($target)) {
            $target = '/';
        }

        return $target;
    }

    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        if (preg_match('/\s/', $requestTarget)) {
            throw new InvalidArgumentException('Request target can\'t contain whitespaces');
        }

        $request                = clone $this;
        $request->requestTarget = $requestTarget;
        return $request;
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    protected $attributes = [];

    protected $cookieParams = [];

    protected $serverParams = [];

    protected $queryParams;

    protected $uploadedFiles;

    protected $parsedBody;

    public function __construct(
        $uri,
        string $method,
        $body = '',
        array $headers = [],
        array $cookies = [],
        array $queryParams = [],
        array $serverParams = [],
        array $uploadedFiles = [],
        $parsedBody = null,
        string $protocolVersion = '1.1'
    ) {
        parent::__construct($uri, $method, $body, $headers, $protocolVersion);

        $this->cookieParams  = $cookies;
        $this->queryParams   = $queryParams;
        $this->serverParams  = $serverParams;
        $this->uploadedFiles = $uploadedFiles;
        $this->parsedBody    = $parsedBody;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($name, $default = null)
    {
        return $this->hasAttribute($name) ? $this->attributes[$name] : $default;
    }

    public function withAttribute($name, $value)
    {
        $request                    = clone $this;
        $request->attributes[$name] = $value;
        return $request;
    }

    public function withoutAttribute($name)
    {
        if (!isset($this->attributes[$name])) {
            return $this;
        }

        $request = clone $this;
        unset($request->attributes[$name]);
        return $request;
    }

    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    public function withServerParams(array $server)
    {
        $this->serverParams = $server;
        return $this;
    }

    public function withCookieParams(array $cookies)
    {
        $request               = clone $this;
        $request->cookieParams = $cookies;
        return $request;
    }

    public function getCookieParams()
    {
        return $this->cookieParams;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getQueryParam($key, $default = false)
    {
        if (isset($this->queryParams[$key])) {
            return $this->queryParams[$key];
        }

        return $default;
    }

    public function withQueryParams(array $query)
    {
        $request              = clone $this;
        $request->queryParams = $query;
        return $request;
    }

    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        $request                = clone $this;
        $request->uploadedFiles = $uploadedFiles;
        return $request;
    }

    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data)
    {
        if (!is_array($data) && !is_object($data) && !is_null($data)) {
            throw new InvalidArgumentException('Error HTTP body.');
        }
        $request             = clone $this;
        $request->parsedBody = $data;
        return $request;
    }

    public static function from(\OpenSwoole\HTTP\Request $request)
    {
        $files = [];

        if (isset($request->files)) {
            foreach ($request->files as $name => $fileData) {
                $files[$name] = new UploadedFile(
                    Stream::createStreamFromFile($fileData['tmp_name']),
                    $fileData['size'],
                    $fileData['error'],
                    $fileData['name'],
                    $fileData['type']
                );
            }
        }

        return new ServerRequest(
            $request->server['request_uri'],
            $request->server['request_method'],
            $request->rawContent() ? $request->rawContent() : 'php://memory',
            $request->header,
            isset($request->cookie) ? $request->cookie : [],
            isset($request->get) ? $request->get : [],
            $request->server,
            $files,
        );
    }

    private function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }
}

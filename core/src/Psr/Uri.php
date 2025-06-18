<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr;

use InvalidArgumentException;
use Psr\Http\Message\UriInterface;
use stdClass;

class Uri implements UriInterface
{
    private const DEFAULT_SCHEME_PORT = [
        'http'  => 80,
        'https' => 443,
    ];

    private const URI_CHAR_SUB_DELIMITERS = "!\$&\\'\\(\\)\\*\\+,;=";

    private const URI_CHAR_UNRESERVED = '\w+\-\.~';

    private $scheme;

    private $host;

    private $port;

    private $userInfo;

    private $path;

    private $query;

    private $fragment;

    public function __construct(string $uri = '')
    {
        $this->apply($this->parse($uri));
    }

    public function __toString(): string
    {
        $uri       = '';
        $authority = $this->getAuthority();
        $query     = $this->getQuery();
        $path      = $this->getPath();
        $fragment  = $this->getFragment();

        if (!empty($this->scheme)) {
            $uri .= $this->scheme . ':';
        }

        if (!empty($authority)) {
            $uri .= '//' . $authority;
        }

        $uri .= $path;

        if (!empty($query) || $query === '0') {
            $uri .= '?' . $query;
        }

        if (!empty($fragment) || $fragment === '0') {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function withScheme($scheme): self
    {
        if (!is_string($scheme)) {
            throw new InvalidArgumentException('Error HTTP schema.');
        }
        $scheme      = $this->normalizeScheme($scheme);
        $uri         = clone $this;
        $uri->scheme = $scheme;
        return $uri;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function withPath($path): self
    {
        $path = $this->normalizePath($path);

        if ($path === $this->path) {
            return $this;
        }

        $this->path = $path;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function withHost($host): self
    {
        $host = $this->normalizeHost($host);

        if ($this->host === $host) {
            return $this;
        }

        $this->host = $host;

        return $this;
    }

    public function getPort(): ?int
    {
        if (empty($this->scheme) && empty($this->port)) {
            return null;
        }

        if (empty($this->port) && !empty($this->scheme)) {
            return null;
        }

        if (!empty($this->port)) {
            return static::DEFAULT_SCHEME_PORT[$this->scheme] !== $this->port ? $this->port : null;
        }

        return null;
    }

    public function withPort($port): self
    {
        if ($port === $this->port) {
            return $this;
        }

        $this->port = $port;

        return $this;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withFragment($fragment): self
    {
        $fragment = $this->normalizeFragmentAndQuery($fragment);

        if ($fragment === $this->fragment) {
            return $this;
        }

        $this->fragment = $fragment;

        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function withQuery($query): self
    {
        $query = $this->normalizeFragmentAndQuery($query);

        if ($query === $this->query) {
            return $this;
        }

        $this->query = $query;

        return $this;
    }

    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    public function withUserInfo($user, $password = null): self
    {
        $userInfo = $user;
        if (!empty($password) || $password === '0') {
            $userInfo .= ':' . $password;
        }

        if ($userInfo === $this->userInfo) {
            return $this;
        }

        $this->userInfo = $userInfo;

        return $this;
    }

    public function getAuthority(): string
    {
        if (empty($this->host) && $this->host !== '0') {
            return '';
        }

        $authority = $this->host;

        if (!empty($this->userInfo)) {
            $authority = $this->userInfo . '@' . $authority;
        }

        if (!empty($this->port) && static::DEFAULT_SCHEME_PORT[$this->scheme] != $this->port) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    private function normalizeScheme(string $scheme): string
    {
        $scheme = strtolower($scheme);

        if (!array_key_exists($scheme, static::DEFAULT_SCHEME_PORT)) {
            throw new InvalidArgumentException(sprintf('%s not supported', $scheme));
        }

        return $scheme;
    }

    private function normalizePath(string $path)
    {
        $pattern = '/(?:[^' . static::URI_CHAR_UNRESERVED . static::URI_CHAR_SUB_DELIMITERS . '\/%@:]++|%(?![A-Fa-f0-9]{2}))/';

        return preg_replace_callback($pattern, [$this, 'rawUrlEncode'], $path);
    }

    private function normalizeHost(string $host): string
    {
        return strtolower($host);
    }

    private function normalizeFragmentAndQuery(string $value): string
    {
        $pattern = '/(?:[^' . static::URI_CHAR_UNRESERVED . static::URI_CHAR_SUB_DELIMITERS . '\/\?%@:]++|%(?![A-Fa-f0-9]{2}))/';

        return preg_replace_callback($pattern, [$this, 'rawUrlEncode'], $value);
    }

    private function normalizeUserInfo(string $infoPart): string
    {
        return $infoPart;
    }

    private function rawUrlEncode(array $matches): string
    {
        return rawurlencode($matches[0]);
    }

    private function parse(string $uri): stdClass
    {
        $res = new stdClass();

        $parsed = parse_url($uri);

        $res->scheme = array_key_exists('scheme', $parsed) ? $this->normalizeScheme($parsed['scheme']) : '';
        $res->host   = array_key_exists('host', $parsed) ? $this->normalizeHost($parsed['host']) : '';
        $res->port   = array_key_exists('port', $parsed) ? $parsed['port'] : null;

        $res->userInfo = array_key_exists('user', $parsed) ? $this->normalizeUserInfo($parsed['user']) : '';
        if (array_key_exists('pass', $parsed)) {
            $res->userInfo .= ':' . $parsed['pass'];
        }

        $res->path     = array_key_exists('path', $parsed) ? $parsed['path'] : '';
        $res->path     = $this->normalizePath($res->path);
        $res->query    = array_key_exists('query', $parsed) ? $parsed['query'] : '';
        $res->fragment = array_key_exists('fragment', $parsed) ? $this->normalizeFragmentAndQuery($parsed['fragment']) : '';

        return $res;
    }

    private function apply(stdClass $obj)
    {
        foreach ($obj as $key => $value) {
            $this->{$key} = $value;
        }
    }
}

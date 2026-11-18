<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr7Test\Tests;

use InvalidArgumentException;
use OpenSwoole\Core\Psr\ServerRequest;
use OpenSwoole\Core\Psr\Uri;
use OpenSwoole\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ServerRequestFromTest extends TestCase
{
    private function request(string $raw): Request
    {
        $request = Request::create();
        $request->parse($raw);
        return $request;
    }

    public function testUriHasHostPortAndQuery()
    {
        $serverRequest = ServerRequest::from($this->request("GET /a?y=1 HTTP/1.1\r\nHost: x:8080\r\n\r\n"));
        $uri           = $serverRequest->getUri();
        $this->assertSame('x', $uri->getHost());
        $this->assertSame(8080, $uri->getPort());
        $this->assertSame('/a', $uri->getPath());
        $this->assertSame('y=1', $uri->getQuery());
        $this->assertSame('http://x:8080/a?y=1', (string) $uri);
        $this->assertSame('1.1', $serverRequest->getProtocolVersion());
    }

    public function testServerParamsHaveServerStyleKeys()
    {
        $params = ServerRequest::from($this->request("GET /a?y=1 HTTP/1.1\r\nHost: x:8080\r\nX-Forwarded-Proto: https\r\n\r\n"))->getServerParams();
        $this->assertSame('GET', $params['REQUEST_METHOD']);
        $this->assertSame('GET', $params['request_method']);
        $this->assertSame('/a', $params['REQUEST_URI']);
        $this->assertSame('y=1', $params['QUERY_STRING']);
        $this->assertSame('x:8080', $params['HTTP_HOST']);
        $this->assertSame('https', $params['HTTP_X_FORWARDED_PROTO']);
    }

    public function testUriWithIpv6Host()
    {
        $uri = ServerRequest::from($this->request("GET / HTTP/1.1\r\nHost: [::1]:9501\r\n\r\n"))->getUri();
        $this->assertSame('[::1]', $uri->getHost());
        $this->assertSame(9501, $uri->getPort());
    }

    public function testRequestTargetThatIsNotAValidUri()
    {
        $serverRequest = ServerRequest::from($this->request("GET ///echo HTTP/1.1\r\nHost: x\r\n\r\n"));
        $this->assertSame('GET', $serverRequest->getMethod());
    }

    public function testInvalidUriThrows()
    {
        $this->expectException(InvalidArgumentException::class);
        new Uri('///echo');
    }

    public function testWithMethodsReturnANewUri()
    {
        $uri = new Uri('http://a/b');
        $uri->withPath('/c')->withHost('d')->withPort(81)->withQuery('q')->withFragment('f')->withUserInfo('u');
        $this->assertSame('http://a/b', (string) $uri);
    }
}

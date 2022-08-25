<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Example\HTTP;

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSwoole\Core\Psr\Middleware\StackHandler;
use OpenSwoole\Core\Psr\Response;
use OpenSwoole\HTTP\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

$server = new Server('127.0.0.1', 9501);

$server->on('start', function (Server $server) {
    echo "OpenSwoole http server is started at http://127.0.0.1:9501\n";
});

class DefaultResponseMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return (new Response('aaaa'))->withHeader('x-a', '1234');
    }
}

class MiddlewareA implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestBody = $request->getBody();
        var_dump('A1');
        return $handler->handle($request);
        var_dump('A2');
    }
}

class MiddlewareB implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestBody = $request->getBody();
        var_dump('B1');
        return $handler->handle($request);
        var_dump('B2');
    }
}

$stack = (new StackHandler())
    ->add(new DefaultResponseMiddleware())
    ->add(new MiddlewareA())
    ->add(new MiddlewareB())
;

$server->setHandler($stack);

$server->start();

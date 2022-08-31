<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use FastRoute\RouteCollector;
use OpenSwoole\Core\Psr\Middleware\StackHandler;
use OpenSwoole\Core\Psr\Response;
use OpenSwoole\HTTP\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

$server = new Server('127.0.0.1', 9501, Server::BASE);

$server->on('start', function (Server $server) {
    echo "OpenSwoole http server is started at http://127.0.0.1:9501\n";
});

class MiddlewareA implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestBody = $request->getBody();
        var_dump('A1');
        $response = $handler->handle($request);
        var_dump('A2');
        return $response;
    }
}

class MiddlewareB implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestBody = $request->getBody();
        var_dump('B1');
        $response = $handler->handle($request);
        var_dump('B2');
        return $response;
    }
}

$dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/hello/{name}', function ($request) {
        $name = $request->getAttribute('name');
        return new Response(sprintf('Hello %s', $name));
    });
});

class RouteMiddleware implements MiddlewareInterface
{
    private $dispatcher;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                return new Response('Not found', 404, '', ['Content-Type' => 'text/plain']);
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                return new Response('Method not allowed', 405, '', ['Content-Type' => 'text/plain']);
            case \FastRoute\Dispatcher::FOUND:
                foreach ($routeInfo[2] as $key => $value) {
                    $request = $request->withAttribute($key, $value);
                }
                return $routeInfo[1]($request);
        }
    }
}

$stack = (new StackHandler())
    ->add(new RouteMiddleware($dispatcher))
    // ->add(new MiddlewareA())
    // ->add(new MiddlewareB())
;

$server->setHandler($stack);

$server->start();

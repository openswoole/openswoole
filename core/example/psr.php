<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
include './vendor/autoload.php';

// $router = new League\Route\Router;

// // map a route
// $router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
//     $response = new \Swoole\Psr\Response;
//     $response->getBody()->write('<h1>Hello, World!</h1>');
//     return $response;
// });

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

if (interface_exists('Psr\Http\Message\ResponseInterface')) {
}

$server = new OpenSwoole\HTTP\Server('127.0.0.1', 9501);

$server->on('start', function (OpenSwoole\Http\Server $server) {
    echo "OpenSwoole http server is started at http://127.0.0.1:9501\n";
});

// $server->on("Request", function( $request,  $response)
// {
// 	var_dump($request);

// 	var_dump($request->rawContent());

//     $response->header("Content-Type", "text/plain");
//     $response->end("Hello World\n");
// });

class DefaultResponseMiddleware
{
    public function process($request, $handler)
    {
        return (new \OpenSwoole\Core\Psr\Response('aaaa'))->withHeader('x-a', '1234');
        // var_dump('0');
    }
}

class MiddlewareA
{
    public function process($request, $handler)
    {
        $requestBody = $request->getBody();
        // var_dump('A1');
        return $handler->handle($request);
        // var_dump('A2');
    }
}

class MiddlewareB
{
    public function process($request, $handler)
    {
        $requestBody = $request->getBody();
        // var_dump('B1');
        return $handler->handle($request);
        // var_dump('B2');
    }
}

$stack = (new \OpenSwoole\Core\Psr\MiddlewareStack())
    ->add(new DefaultResponseMiddleware())
    ->add(new MiddlewareA())
    ->add(new MiddlewareB())
;

$server->handle(function ($request) use ($stack) {
    return $stack->handle($request);
});

// $server->handle(function($request) {
// 	$request = $request->withHeader('foo', 'bar')->withAddedHeader('foo', 'baz');
// 	return (new \OpenSwoole\Core\Psr\Response('openswoole'))->withHeader('x-a', 'a');
// });

// $server->handle(function($request) use ($router) {
// 	$request = (\Psr\Http\Message\ServerRequestInterface) $request;
// 	$response = $router->dispatch($request);
// 	return $response->withHeader('x-a', 'a');
// });

$server->start();

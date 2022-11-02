<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSwoole\HTTP\Server;
use Slim\Factory\AppFactory;

$container = new League\Container\Container();
$container->add(AppFactory::class);
$container->add(Server::class)->addArguments(['127.0.0.1', 9501]);

$app = $container->get(AppFactory::class)->create();
$app->get('/hello/{name}', function ($request, $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, {$name}");
    return $response;
});

$server = $container->get(Server::class);
$server->handle(function ($request) use ($app) {
    return $app->handle($request);
});
$server->start();

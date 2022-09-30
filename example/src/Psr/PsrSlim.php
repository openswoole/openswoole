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

$app = AppFactory::create();
$app->get('/hello/{name}', function ($request, $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$server = new Server('127.0.0.1', 9501);
$server->handle(function ($request) use ($app) {
    return $app->handle($request);
});
$server->start();

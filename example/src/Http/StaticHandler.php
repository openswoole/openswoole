<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$http = new OpenSwoole\Http\Server('0.0.0.0', 9501, OpenSwoole\Server::SIMPLE_MODE);

$http->set([
    'enable_static_handler' => true,
    'http_autoindex'        => true,
    'document_root'         => realpath(__DIR__ . '/../www/'),
]);

$http->on('request', function ($req, $resp) {
    $resp->end("hello world\n");
});

$http->start();

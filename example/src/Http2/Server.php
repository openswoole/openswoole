<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use OpenSwoole\Constant;

co::set([
    'trace_flags' => Constant::TRACE_HTTP2,
    'log_level'   => Constant::LOG_DEBUG,
]);

$keyDir = __DIR__ . '/../ssl/';

$http = new OpenSwoole\Http\Server('0.0.0.0', 9501, OpenSwoole\Server::SIMPLE_MODE, Constant::SOCK_TCP | Constant::SSL);
$http->set([
    'open_http2_protocol'   => 1,
    'enable_static_handler' => true,
    'document_root'         => dirname(__DIR__),
    'ssl_cert_file'         => $keyDir . '/ssl.crt',
    'ssl_key_file'          => $keyDir . '/ssl.key',
]);

$http->on('request', function (OpenSwoole\Http\Request $request, OpenSwoole\Http\Response $response) {
    $response->header('Test-Value', [
        "a\r\n",
        'd5678',
        "e  \n ",
        null,
        5678,
        3.1415926,
    ]);
    $response->end('<h1>Hello OpenSwoole.</h1>');
});

$http->start();

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$ws = new OpenSwoole\WebSocket\Server('127.0.0.1', 9501, OpenSwoole\Server::SIMPLE_MODE);
$ws->set([
    'log_file' => '/dev/null',
]);

$ws->on('start', function () {
    echo 'OpenSwoole Websocket server on :9501', PHP_EOL;
});

$ws->on('open', function (OpenSwoole\WebSocket\Server $serv, OpenSwoole\Http\Request $request) {
    $serv->push($request->fd, 'Hello world');
});

$ws->on('message', function (OpenSwoole\WebSocket\Server $serv, OpenSwoole\Websocket\Frame $frame) {
    $serv->push($frame->fd, 'response: ' . $frame->data);
});

$ws->start();

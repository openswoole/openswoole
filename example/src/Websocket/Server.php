<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use OpenSwoole\WebSocket\Frame;
use OpenSwoole\WebSocket\Server;

$server = new Server('0.0.0.0', 9502);

$server->on('Start', function (Server $server) {
    echo "OpenSwoole WebSocket Server is started at http://127.0.0.1:9502\n";
});

$server->on('Open', function (Server $server, OpenSwoole\Http\Request $request) {
    echo "connection open: {$request->fd}\n";

    $server->tick(1000, function () use ($server, $request) {
        $server->push($request->fd, json_encode(['hello', time()]));
    });
});

$server->on('Message', function (Server $server, Frame $frame) {
    echo "received message: {$frame->data}\n";
    $server->push($frame->fd, json_encode(['hello', time()]));
});

$server->on('Close', function (Server $server, int $fd) {
    echo "connection close: {$fd}\n";
});

$server->on('Disconnect', function (Server $server, int $fd) {
    echo "connection disconnect: {$fd}\n";
});

$server->start();

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$serv = new OpenSwoole\Server('::1', 9501, OpenSwoole\Server::SIMPLE_MODE, OpenSwoole\Constant::SOCK_TCP6);

$serv->set([
    'worker_num' => 1,
]);

$serv->on('connect', function ($serv, $fd, $reactor_id) {
    echo '[#' . posix_getpid() . "]\tClient@[{$fd}:{$reactor_id}]: Connect.\n";
});

$serv->on('receive', function (OpenSwoole\Server $serv, $fd, $reactor_id, $data) {
    echo '[#' . posix_getpid() . "]\tClient[{$fd}]: {$data}\n";
    var_dump($serv->connection_info($fd));
    $serv->send($fd, json_encode(['hello' => '1213', 'bat' => 'ab']));
    // $serv->close($fd);
});

$serv->on('close', function ($serv, $fd, $reactor_id) {
    echo '[#' . posix_getpid() . "]\tClient@[{$fd}:{$reactor_id}]: Close.\n";
});

$serv->start();

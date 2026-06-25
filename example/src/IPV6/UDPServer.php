<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$serv = new OpenSwoole\Server('::1', 9502, OpenSwoole\Server::SIMPLE_MODE, OpenSwoole\Constant::SOCK_UDP6);
$serv->set([
    'worker_num' => 1,
]);

$serv->on('receive', function (OpenSwoole\Server $serv, $fd, $reactor_id, $data) {
    echo '[#' . posix_getpid() . "]\tClient[{$fd}]: {$data}\n";
    var_dump($serv->connection_info($fd, $reactor_id));
    $serv->send($fd, json_encode(['hello' => '1213', 'bat' => 'ab']));
    // $serv->close($fd);
});

$serv->on('packet', function (OpenSwoole\Server $serv, $data, $clientInfo) {
    var_dump($data, $clientInfo);
});

$serv->start();

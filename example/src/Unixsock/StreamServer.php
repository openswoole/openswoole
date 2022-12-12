<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$serv = new OpenSwoole\Server(__DIR__ . '/svr.sock', 9501, \OpenSwoole\Server::SIMPLE_MODE, \OpenSwoole\Constant::SOCK_UNIX_STREAM);
$serv->set([
    // 'tcp_defer_accept' => 5,
    'worker_num' => 1,
    // 'daemonize' => true,
    // 'log_file' => '/tmp/swoole.log'
]);

$serv->on('start', function ($serv) {
    chmod($serv->host, 0777);
});

$serv->on('Connect', function ($serv, $fd, $reactorId) {
    echo "Connect, client={$fd}\n";
});

$serv->on('Close', function ($serv, $fd, $reactorId) {
    echo "Close, client={$fd}\n";
});

$serv->on('receive', function (OpenSwoole\Server $serv, $fd, $reactor_id, $data) {
    echo '[#' . posix_getpid() . "]\tClient[{$fd}]: {$data}\n";
    $serv->send($fd, json_encode(['hello' => $data, 'from' => $reactor_id]) . PHP_EOL);
});

$serv->start();

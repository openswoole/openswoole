<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$serv = new OpenSwoole\Server(__DIR__ . '/svr.sock', 9501, \OpenSwoole\Server::SIMPLE_MODE, \OpenSwoole\Constant::SOCK_UNIX_DGRAM);
$serv->set([
    // 'tcp_defer_accept' => 5,
    'worker_num' => 1,
    // 'daemonize' => true,
    // 'log_file' => '/tmp/swoole.log'
]);
// $serv->on('receive', function (Swoole\Server $serv, $fd, $reactor_id, $data) {
//    echo "[#".posix_getpid()."]\tClient[$fd]: $data\n";
//    $serv->send($fd, json_encode(array("hello" => $data, "from" => $reactor_id)).PHP_EOL);
// });

$serv->on('Packet', function (OpenSwoole\Server $serv, $data, $addr) {
    // echo "[#".posix_getpid()."]\tClient[{$addr['address']}]: $data\n";
    var_dump($addr);
    $serv->send($addr['address'], json_encode(['hello' => $data, 'addr' => $addr]) . PHP_EOL);
});

$serv->start();

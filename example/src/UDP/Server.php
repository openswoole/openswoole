<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$server = new OpenSwoole\Server('0.0.0.0', 9905, \OpenSwoole\Server::SIMPLE_MODE, \OpenSwoole\Constant::SOCK_UDP);
for ($i = 0; $i < 20; $i++) {
    $server->listen('0.0.0.0', 9906 + $i, \OpenSwoole\Constant::SOCK_UDP);
}
$server->set(['worker_num' => 4]);

$server->on('Packet', function (OpenSwoole\Server $serv, $data, $addr) {
    var_dump($data);
    $serv->sendto($addr['address'], $addr['port'], "Swoole: {$data}", $addr['server_socket']);
});

$server->start();

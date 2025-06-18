<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$client = new OpenSwoole\Client(OpenSwoole\Constant::SOCK_TCP);

if (!$client->connect('127.0.0.1', 8089, -1)) {
    exit("connect failed. Error: {$client->errCode}\n");
}

function _send(swoole_client $client, $data)
{
    return $client->send(pack('N', strlen($data)) . $data);
}

var_dump($client->getsockname());

_send($client, 'hello world');
_send($client, 'hello world [2]');

$client->close();

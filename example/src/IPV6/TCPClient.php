<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$client = new OpenSwoole\Client(\OpenSwoole\Constant::SOCK_TCP6);
if (!$client->connect('::1', 9501, -1)) {
    exit("connect failed. Error: {$client->errCode}\n");
}

var_dump($client->getsockname());

for ($i = 0; $i < 1; $i++) {
    $client->send("hello world\n");
    echo $client->recv();
    usleep(2000);
}

$client->close();

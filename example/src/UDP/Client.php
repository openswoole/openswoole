<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
$client = new OpenSwoole\Client(\OpenSwoole\Constant::SOCK_TCP, \OpenSwoole\Constant::SOCK_SYNC);
$client->connect('127.0.0.1', 9905);
$client->send(serialize(['hello' => str_repeat('A', 600), 'rand' => rand(1, 100)]));
echo $client->recv() . "\n";
sleep(1);

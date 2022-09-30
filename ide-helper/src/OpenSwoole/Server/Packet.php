<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\Server;

class Packet
{
    public int $server_socket;

    public int $server_port;

    public float $dispatch_time;

    public string $address;

    public int $port;
}

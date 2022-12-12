<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
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

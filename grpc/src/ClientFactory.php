<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC;

final class ClientFactory
{
    public static function make($config)
    {
        return (new Client($config['host'], $config['port']))->connect();
    }
}

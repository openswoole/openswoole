<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Client;

final class MysqliClientFactory implements ClientFactoryInterface
{
    public static function make($config)
    {
        return new MysqliClient($config);
    }
}

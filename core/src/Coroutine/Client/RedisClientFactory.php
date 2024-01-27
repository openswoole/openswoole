<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Client;

use Redis;

final class RedisClientFactory implements ClientFactoryInterface
{
    public static function make($config)
    {
        $redis     = new Redis();
        $arguments = [
            $config->getHost(),
            $config->getPort(),
        ];
        if ($config->getTimeout() !== 0.0) {
            $arguments[] = $config->getTimeout();
        }
        if ($config->getRetryInterval() !== 0) {
            /* reserved should always be NULL */
            $arguments[] = null;
            $arguments[] = $config->getRetryInterval();
        }
        if ($config->getReadTimeout() !== 0.0) {
            $arguments[] = $config->getReadTimeout();
        }
        $redis->connect(...$arguments);
        if ($config->getAuth()) {
            $redis->auth($config->getAuth());
        }
        if ($config->getDbIndex() !== 0) {
            $redis->select($config->getDbIndex());
        }
        return $redis;
    }
}

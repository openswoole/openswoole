<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Client;

use OpenSwoole\Client\Exception;
use OpenSwoole\Coroutine\PostgreSQL;

final class PostgresClientFactory implements ClientFactoryInterface
{
    /**
     * @throws Exception
     */
    public static function make($config)
    {
        if ($config instanceof PostgresConfig) {
            $postgres = new PostgreSQL();
            $postgres->connect($config->getConnectionString());
            return $postgres;
        }

        throw new Exception('Wrong config used');
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Core\Coroutine\Client;

class PostgresConfig extends PDOConfig
{
    public const DRIVER_PSQL = 'pgsql';

    /** @var string */
    protected $driver = self::DRIVER_PSQL;

    /** @var int */
    protected $port = 5432;

    /** @var string */
    protected $username = 'postgres';

    public function getConnectionString(): string
    {
        return 'host=' . $this->host .
            ';port=' . $this->port .
            ';dbname=' . $this->dbname .
            ';user=' . $this->username .
            ';password=' . $this->password;
    }
}

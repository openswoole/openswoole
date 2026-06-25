<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Coroutine;

class PostgreSQL
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function connect(string $conninfo, float $timeout = 2): bool
    {
    }

    public function query(string $query): false|PostgreSQLStatement
    {
    }

    public function prepare(string $query): false|PostgreSQLStatement
    {
    }

    public function escape(string $string): false|string
    {
    }

    public function escapeLiteral(string $string): false|string
    {
    }

    public function escapeIdentifier(string $string): false|string
    {
    }

    public function metaData(string $table_name): false|array
    {
    }

    public function createLOB(): int|false
    {
    }

    /**
     * @param string $mode [optional] = "rb"
     * @return resource|false
     */
    public function openLOB(int $oid, string $mode = 'rb')
    {
    }

    public function unlinkLOB(int $oid): bool
    {
    }

    public function status(): int|false
    {
    }

    public function reset(float $timeout = 0): bool
    {
    }
}

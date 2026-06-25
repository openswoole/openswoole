<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Coroutine;

class PostgreSQLStatement
{
    public function execute(array $params = []): bool
    {
    }

    public function fetchAll(int $result_type = 2): false|array
    {
    }

    public function fetchObject(?int $row = null, ?string $class_name = null, array $ctor_params = []): false|object
    {
    }

    public function fetchAssoc(?int $row = null): false|array
    {
    }

    public function fetchArray(?int $row = null, int $result_type = 3): false|array
    {
    }

    public function fetchRow(?int $row = null, int $result_type = 1): false|array
    {
    }

    public function affectedRows(): false|int
    {
    }

    public function numRows(): false|int
    {
    }

    public function fieldCount(): false|int
    {
    }
}

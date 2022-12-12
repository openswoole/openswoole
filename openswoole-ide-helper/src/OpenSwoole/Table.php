<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

use Countable;
use Iterator;

final class Table implements Iterator, Countable
{
    public const TYPE_INT = 1;

    public const TYPE_STRING = 3;

    public const TYPE_FLOAT = 2;

    public int $size;

    public int $memorySize;

    /**
     * @param int $size [required]
     * @param float $conflictProportion [optional] = 1
     */
    public function __construct(int $size, float $conflictProportion = 1)
    {
    }

    /**
     * @param string $name [required]
     * @param int $type [required]
     * @param int $size [optional] = 0
     */
    public function column(string $name, int $type, int $size = 0): bool
    {
    }

    public function create(): bool
    {
    }

    public function destroy(): bool
    {
    }

    /**
     * @param string $key [required]
     * @param array $value [required]
     */
    public function set(string $key, array $value): bool
    {
    }

    /**
     * @param string $key [required]
     * @param string $column [optional] = ''
     * @return array|bool|string|int|float
     */
    public function get(string $key, string $column = '')
    {
    }

    public function count(): int
    {
    }

    /**
     * @param string $key [required]
     */
    public function del(string $key): bool
    {
    }

    /**
     * @param string $key [required]
     */
    public function exists(string $key): bool
    {
    }

    /**
     * @param string $key [required]
     * @param string $column [required]
     * @param int $incrBy [optional] = 1
     */
    public function incr(string $key, string $column, int $incrBy = 1): int
    {
    }

    /**
     * @param string $key [required]
     * @param string $column [required]
     * @param int $decrBy [optional] = 1
     */
    public function decr(string $key, string $column, int $decrBy = 1): int
    {
    }

    public function getSize(): int
    {
    }

    public function getMemorySize(): int
    {
    }

    public function rewind(): void
    {
    }

    public function valid(): bool
    {
    }

    public function next(): void
    {
    }

    /**
     * @return ?array
     */
    public function current(): ?array
    {
    }

    /**
     * @return ?string
     */
    public function key(): ?string
    {
    }
}

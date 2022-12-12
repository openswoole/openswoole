<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Atomic;

class Long
{
    /**
     * @param int $value [optional] = 0
     */
    public function __construct(int $value = 0)
    {
    }

    /**
     * @param int $value [optional] = 1
     */
    public function add(int $value = 1): int
    {
    }

    /**
     * @param int $value [optional] = 1
     */
    public function sub(int $value = 1): int
    {
    }

    public function get(): int
    {
    }

    /**
     * @param int $value [required]
     * @return ?bool
     */
    public function set(int $value): ?bool
    {
    }

    /**
     * @param int $cmpVal [optional] = 0
     * @param int $newVal [optional] = 0
     */
    public function cmpset(int $cmpVal = 0, int $newVal = 0): bool
    {
    }
}

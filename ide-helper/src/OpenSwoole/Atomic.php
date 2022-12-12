<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

class Atomic
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
     * @param float $timeout [optional] = 1
     */
    public function wait(float $timeout = 1): bool
    {
    }

    /**
     * @param int $count [optional] = 1
     */
    public function wakeup(int $count = 1): bool
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

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Coroutine;

final class Scheduler
{
    /**
     * @param callable $callback [required]
     */
    public function add(callable $callback, ...$params): ?bool
    {
    }

    /**
     * @param int $count [required]
     * @param callable $callback [required]
     */
    public function parallel(int $count, callable $callback, ...$params): void
    {
    }

    /**
     * @param array $settings [required]
     */
    public function set(array $settings): void
    {
    }

    public function getOptions(): ?array
    {
    }

    public function start(): bool
    {
    }
}

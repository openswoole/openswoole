<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\Coroutine;

final class Scheduler
{
    /**
     * @param callable $callback [required]
     * @param mixed ...$params
     * @return ?bool
     */
    public function add(callable $callback, ...$params): ?bool
    {
    }

    /**
     * @param int $count [required]
     * @param callable $callback [required]
     * @param mixed ...$params
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

    /**
     * @return ?array
     */
    public function getOptions(): ?array
    {
    }

    public function start(): bool
    {
    }
}

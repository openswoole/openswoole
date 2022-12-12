<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

final class Timer
{
    public const TIMER_MIN_MS = 1;

    public const TIMER_MIN_SEC = 0.001;

    public const TIMER_MAX_MS = 9223372036854775807;

    public const TIMER_MAX_SEC = 9.2233720368548E+15;

    /**
     * @param array $settings [required]
     */
    public static function set(array $settings): bool
    {
    }

    /**
     * @param int $ms [required]
     * @param callable $callback [required]
     * @param mixed ...$params
     * @return int|false
     */
    public static function after(int $ms, callable $callback, ...$params)
    {
    }

    /**
     * @param int $ms [required]
     * @param callable $callback [required]
     * @param mixed ...$params
     * @return int|false
     */
    public static function tick(int $ms, callable $callback, ...$params)
    {
    }

    public static function exists(): bool
    {
    }

    /**
     * @return array|false
     */
    public static function info()
    {
    }

    public static function stats(): array
    {
    }

    /**
     * @return \OpenSwoole\Timer\Iterator
     */
    public static function list(): Timer\Iterator
    {
    }

    public static function clear(int $timerId): bool
    {
    }

    public static function clearAll(): bool
    {
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

use const SWOOLE_EVENT_READ;

class Event
{
    /**
     * @param mixed $sock [required]
     * @param callable|null $readCallback [optional] = null
     * @param callable|null $writeCallback [optional] = null
     * @param int $flags [optional] = \SWOOLE_EVENT_READ
     */
    public static function add($sock, ?callable $readCallback = null, ?callable $writeCallback = null, int $flags = SWOOLE_EVENT_READ)
    {
    }

    /**
     * @param mixed $sock [required]
     */
    public static function del($sock): bool
    {
    }

    /**
     * @param mixed $sock [required]
     * @param callable|null $readCallback [optional] = null
     * @param callable|null $writeCallback [optional] = null
     * @param int $flags [optional] = \SWOOLE_EVENT_READ
     */
    public static function set($sock, ?callable $readCallback = null, ?callable $writeCallback = null, int $flags = SWOOLE_EVENT_READ): bool
    {
    }

    /**
     * @param mixed $sock [required]
     * @param int $flags [optional] = 1536
     */
    public static function isset($sock, int $flags = 1536): bool
    {
    }

    public static function dispatch(): bool
    {
    }

    /**
     * @param callable $callback [required]
     */
    public static function defer(callable $callback): bool
    {
    }

    /**
     * @param callable $callback [required]
     * @param bool $before [optional] = false
     */
    public static function cycle(callable $callback, bool $before = false): bool
    {
    }

    /**
     * @param mixed $sock [required]
     * @param string $data [required]
     */
    public static function write($sock, string $data): bool
    {
    }

    public static function wait(): void
    {
    }

    public static function exit(): void
    {
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole;

use const AF_INET;
use const DEBUG_BACKTRACE_PROVIDE_OBJECT;
use const SOCK_STREAM;
use const STREAM_IPPROTO_TCP;

final class Coroutine
{
    public const DEFAULT_MAX_CORO_NUM = 100000;

    public const CORO_MAX_NUM_LIMIT = 9223372036854775807;

    public const CORO_INIT = 0;

    public const CORO_WAITING = 1;

    public const CORO_RUNNING = 2;

    public const CORO_END = 3;

    public const EXIT_IN_COROUTINE = 2;

    public const EXIT_IN_SERVER = 4;

    /**
     * @param callable $callback [required]
     */
    public static function create(callable $callback, ...$params): int|false
    {
    }

    /**
     * @param callable $callback [required]
     */
    public static function defer(callable $callback): void
    {
    }

    /**
     * @param array $options [required]
     */
    public static function set(array $options): mixed
    {
    }

    public static function getOptions(): ?array
    {
    }

    /**
     * @param int $cid [required]
     */
    public static function exists(int $cid): bool
    {
    }

    public static function yield(): bool
    {
    }

    /**
     * @param int $cid [required]
     */
    public static function cancel(int $cid): bool
    {
    }

    public static function isCanceled(): bool
    {
    }

    /**
     * @param int $cid [required]
     */
    public static function resume(int $cid): bool
    {
    }

    public static function stats(): array
    {
    }

    public static function select(array $read = [], array $write = [], float $timeout = -1): mixed
    {
    }

    public static function getCid(): int
    {
    }

    /**
     * @param int $cid [optional] = 0
     */
    public static function getPcid(int $cid = 0): int
    {
    }

    /**
     * @param int $cid [optional] = 0
     */
    public static function getContext(int $cid = 0): ?Coroutine\Context
    {
    }

    /**
     * @param int $cid [optional] = 0
     * @param int $options [optional] = \DEBUG_BACKTRACE_PROVIDE_OBJECT
     * @param int $limit [optional] = 0
     */
    public static function getBackTrace(int $cid = 0, int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0): array|false
    {
    }

    /**
     * @param int $cid [optional] = 0
     * @param int $options [optional] = \DEBUG_BACKTRACE_PROVIDE_OBJECT
     * @param int $limit [optional] = 0
     */
    public static function printBackTrace(int $cid = 0, int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0): void
    {
    }

    /**
     * @param int $cid [optional] = 0
     */
    public static function getElapsed(int $cid = 0): int
    {
    }

    /**
     * @param int $cid [optional] = 0
     */
    public static function getStackUsage(int $cid = 0): int|false
    {
    }

    public static function list(): Coroutine\Iterator
    {
    }

    public static function enableScheduler(): bool
    {
    }

    public static function disableScheduler(): bool
    {
    }

    /**
     * @param string $domain [required]
     * @param int $family [optional] = \AF_INET
     * @param float $timeout [optional] = -1
     */
    public static function gethostbyname(string $domain, int $family = AF_INET, float $timeout = -1): string|false
    {
    }

    /**
     * @param string $domain [required]
     * @param float $timeout [optional] = 5
     */
    public static function dnsLookup(string $domain, float $timeout = 5): string|false
    {
    }

    /**
     * @param string $command [required]
     * @param bool $get_error_stream [optional] = false
     */
    public static function exec(string $command, bool $get_error_stream = false): array|false
    {
    }

    /**
     * @param int $seconds [required]
     */
    public static function sleep(int $seconds): bool
    {
    }

    /**
     * @param int $microseconds [required]
     */
    public static function usleep(int $microseconds): bool
    {
    }

    /**
     * @param string $domain [required]
     * @param int $family [optional] = \AF_INET
     * @param int $sockType [optional] = \SOCK_STREAM
     * @param int $protocol [optional] = \STREAM_IPPROTO_TCP
     * @param string $service [optional] = null
     * @param float $timeout [optional] = -1
     */
    public static function getaddrinfo(string $domain, int $family = AF_INET, int $sockType = SOCK_STREAM, int $protocol = STREAM_IPPROTO_TCP, ?string $service = null, float $timeout = -1): array|false
    {
    }

    /**
     * @param string $path [required]
     */
    public static function statvfs(string $path): bool|array
    {
    }

    /**
     * @param string $filename [required]
     * @param int $flags [optional] = 0
     */
    public static function readFile(string $filename, int $flags = 0): false|string
    {
    }

    /**
     * @param string $filename [required]
     * @param string $data [required]
     * @param int $flags [optional] = 0
     */
    public static function writeFile(string $filename, string $data, int $flags = 0): bool|int
    {
    }

    /**
     * @param float $timeout [optional] = -1
     */
    public static function wait(float $timeout = -1): bool|array
    {
    }

    /**
     * @param int $pid [required]
     * @param float $timeout [optional] = -1
     */
    public static function waitPid(int $pid, float $timeout = -1): bool|array
    {
    }

    /**
     * @param int $signalNum [required]
     * @param float $timeout [optional] = -1
     */
    public static function waitSignal(int $signalNum, float $timeout = -1): bool
    {
    }

    /**
     * @param mixed $fd [required]
     * @param int $events [required]
     * @param float $timeout [optional] = -1
     */
    public static function waitEvent($fd, int $events, float $timeout = -1): bool|int
    {
    }

    public static function clearDNSCache(): void
    {
    }

    public static function run(callable $callback, mixed ...$params): ?bool
    {
    }
}

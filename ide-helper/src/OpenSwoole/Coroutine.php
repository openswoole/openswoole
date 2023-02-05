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
     * @param mixed ...$params
     * @return int|false
     */
    public static function create(callable $callback, ...$params)
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
     * @return mixed
     */
    public static function set(array $options)
    {
    }

    /**
     * @return ?array
     */
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

    public static function suspend(): bool
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

    /**
     * @return mixed
     */
    public static function select(array $read = [], array $write = [], float $timeout = -1)
    {
    }

    public static function getCid(): int
    {
    }

    public static function getuid(): int
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
     * @return \OpenSwoole\Coroutine\Context|null
     */
    public static function getContext(int $cid = 0): ?Coroutine\Context
    {
    }

    /**
     * @param int $cid [optional] = 0
     * @param int $options [optional] = \DEBUG_BACKTRACE_PROVIDE_OBJECT
     * @param int $limit [optional] = 0
     * @return array|false
     */
    public static function getBackTrace(int $cid = 0, int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0)
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
    public static function getStackUsage(int $cid = 0)
    {
    }

    /**
     * @return \OpenSwoole\Coroutine\Iterator
     */
    public static function list(): Coroutine\Iterator
    {
    }

    /**
     * @return \OpenSwoole\Coroutine\Iterator
     */
    public static function listCoroutines(): Coroutine\Iterator
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
     * @return string|false
     */
    public static function gethostbyname(string $domain, int $family = AF_INET, float $timeout = -1)
    {
    }

    /**
     * @param string $domain [required]
     * @param float $timeout [optional] = 5
     * @return string|false
     */
    public static function dnsLookup(string $domain, float $timeout = 5)
    {
    }

    /**
     * @param string $command [required]
     * @param bool $get_error_stream [optional] = false
     * @return array|false
     */
    public static function exec(string $command, bool $get_error_stream = false)
    {
    }

    /**
     * @param int $seconds [required]
     */
    public static function sleep(int $seconds): bool
    {
    }

    /**
     * @param int $milliseconds [required]
     */
    public static function usleep(int $milliseconds): bool
    {
    }

    /**
     * @param string $domain [required]
     * @param int $family [optional] = \AF_INET
     * @param int $sockType [optional] = \SOCK_STREAM
     * @param int $protocol [optional] = \STREAM_IPPROTO_TCP
     * @param string $service [optional] = null
     * @param float $timeout [optional] = -1
     * @return array|false
     */
    public static function getaddrinfo(string $domain, int $family = AF_INET, int $sockType = SOCK_STREAM, int $protocol = STREAM_IPPROTO_TCP, string $service = null, float $timeout = -1)
    {
    }

    /**
     * @param string $path [required]
     * @return array|false
     */
    public static function statvfs(string $path)
    {
    }

    /**
     * @param string $filename [required]
     * @param int $flags [optional] = 0
     * @return string|false
     */
    public static function readFile(string $filename, int $flags = 0)
    {
    }

    /**
     * @param string $filename [required]
     * @param string $data [required]
     * @param int $flags [optional] = 0
     */
    public static function writeFile(string $filename, string $data, int $flags = 0): bool
    {
    }

    /**
     * @param float $timeout [optional] = -1
     * @return array|false
     */
    public static function wait(float $timeout = -1)
    {
    }

    /**
     * @param int $pid [required]
     * @param float $timeout [optional] = -1
     * @return array|false
     */
    public static function waitPid(int $pid, float $timeout = -1)
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
     * @return int|false
     */
    public static function waitEvent($fd, int $events, float $timeout = -1)
    {
    }

    /**
     * @param mixed $handle [required]
     * @param int $length [optional] = 0
     */
    public static function fread($handle, int $length = 0)
    {
    }

    /**
     * @param mixed $handle [required]
     * @param string $data [required]
     * @param int $length [optional] = 0
     */
    public static function fwrite($handle, string $data, int $length = 0)
    {
    }

    /**
     * @param mixed $handle [required]
     */
    public static function fgets($handle): string
    {
    }
}

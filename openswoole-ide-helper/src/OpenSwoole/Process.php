<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

use Closure;

use const SIGTERM;
use const SOCK_DGRAM;

class Process
{
    public const IPC_NOWAIT = 256;

    public const PIPE_MASTER = 1;

    public const PIPE_WORKER = 2;

    public const PIPE_READ = 3;

    public const PIPE_WRITE = 4;

    public int $pipe;

    public $msgQueueId;

    public $msgQueueKey;

    public ?int $pid;

    public $id;

    private Closure $callback;

    /**
     * @param callable $callback [required]
     * @param bool $redirectStdIO [optional] = false
     * @param int $pipeType [optional] = \SOCK_DGRAM
     * @param bool $enableCoroutine [optional] = false
     */
    public function __construct(callable $callback, bool $redirectStdIO = false, int $pipeType = SOCK_DGRAM, bool $enableCoroutine = false)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param bool $blocking [optional] = true
     * @return array|bool
     */
    public static function wait(bool $blocking = true)
    {
    }

    /**
     * @param int $sigNo [required]
     * @param callable|null $callback [optional] = null
     */
    public static function signal(int $sigNo, ?callable $callback = null): bool
    {
    }

    /**
     * @param int $intervalUsec [required]
     * @param int $type [optional]
     */
    public static function alarm(int $intervalUsec, int $type): bool
    {
    }

    /**
     * @param int $pid [required]
     * @param int $sigNo [optional] = \SIGTERM
     */
    public static function kill(int $pid, int $sigNo = SIGTERM): bool
    {
    }

    /**
     * @param bool $noChdir [optional] = true
     * @param bool $noClose [optional] = true
     * @param array|null $pipes [optional] = null
     */
    public static function daemon(bool $noChdir = true, bool $noClose = true, ?array $pipes = null): bool
    {
    }

    /**
     * @param int $which [required]
     * @param int $priority [required]
     */
    public function setPriority(int $which, int $priority): bool
    {
    }

    /**
     * @param int $which [required]
     */
    public function getPriority(int $which): int
    {
    }

    /**
     * @param array $settings [required]
     */
    public function set(array $settings): void
    {
    }

    /**
     * @param float $timeout [required]
     */
    public function setTimeout(float $timeout): void
    {
    }

    /**
     * @param bool $blocking [required]
     */
    public function setBlocking(bool $blocking): void
    {
    }

    /**
     * @param int $key [optional] = 0
     * @param int $mode [optional] = 2
     * @param int $capacity [optional] = -1
     */
    public function useQueue(int $key = 0, int $mode = 2, int $capacity = -1): bool
    {
    }

    public function statQueue(): array
    {
    }

    public function freeQueue(): bool
    {
    }

    public function start(): int
    {
    }

    /**
     * @param string $data [required]
     */
    public function write(string $data): int
    {
    }

    /**
     * @param int $reason [optional] = 0
     */
    public function close(int $reason = 0): bool
    {
    }

    /**
     * @param int $bufferSize [optional] = 8192
     */
    public function read(int $bufferSize = 8192): string
    {
    }

    /**
     * @param string $data [required]
     */
    public function push(string $data): bool
    {
    }

    /**
     * @param int $maxSize [optional] = 8192
     */
    public function pop(int $maxSize = 8192): string
    {
    }

    /**
     * @param int $status [optional] = 0
     */
    public function exit(int $status = 0): int
    {
    }

    /**
     * @param string $execFile [required]
     * @param array $args [required]
     */
    public function exec(string $execFile, array $args): bool
    {
    }

    public function exportSocket()
    {
    }

    /**
     * @param string $processName [required]
     */
    public function name(string $processName): bool
    {
    }

    public function setAffinity(array $cpu_set): bool
    {
    }
}

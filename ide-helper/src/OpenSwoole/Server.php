<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

use OpenSwoole\Server\Port;

class Server
{
    public const SIMPLE_MODE = 1;

    public const POOL_MODE = 2;

    public const IPC_UNSOCK = 1;

    public const IPC_MSGQUEUE = 2;

    public const IPC_PREEMPTIVE = 3;

    public const DISPATCH_RESULT_DISCARD_PACKET = -1;

    public const DISPATCH_RESULT_CLOSE_CONNECTION = -2;

    public const DISPATCH_RESULT_USERFUNC_FALLBACK = -3;

    public const TASK_TMPFILE = 1;

    public const TASK_SERIALIZE = 2;

    public const TASK_NONBLOCK = 4;

    public const TASK_CALLBACK = 8;

    public const TASK_WAITALL = 16;

    public const TASK_COROUTINE = 32;

    public const TASK_PEEK = 64;

    public const TASK_NOREPLY = 128;

    public const WORKER_BUSY = 1;

    public const WORKER_IDLE = 2;

    public const WORKER_EXIT = 3;

    public const STATS_DEFAULT = 0;

    public const STATS_JSON = 1;

    public const STATS_OPENMETRICS = 2;

    public $setting;

    public $connections;

    public $host;

    public $port;

    public $type;

    public $mode;

    public $ports;

    public $master_pid;

    public $manager_pid;

    public $worker_id;

    public $taskworker;

    public $worker_pid;

    public $stats_timer;

    private $onStart;

    private $onShutdown;

    private $onWorkerStart;

    private $onWorkerStop;

    private $onBeforeReload;

    private $onAfterReload;

    private $onWorkerExit;

    private $onWorkerError;

    private $onTask;

    private $onFinish;

    private $onManagerStart;

    private $onManagerStop;

    private $onPipeMessage;

    public function __construct(string $host, int $port = 0, int $mode = \OpenSwoole\Server::SIMPLE_MODE, int $sockType = \OpenSwoole\Constant::SOCK_TCP)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return false|Port
     */
    public function listen(string $host, int $port, int $sockType)
    {
    }

    /**
     * @return false|Port
     */
    public function addlistener(string $host, int $port, int $sockType)
    {
    }

    public function on(string $event, callable $callback): bool
    {
    }

    public function handle(callable $callback): bool
    {
    }

    /**
     * @param mixed $handler
     */
    public function setHandler($handler): bool
    {
    }

    /**
     * @return mixed
     */
    public function getCallback(string $event)
    {
    }

    public function set(array $settings): bool
    {
    }

    public function start(): bool
    {
    }

    /**
     * @param string|int $fd
     * @param mixed $data
     */
    public function send($fd, $data, int $serverSocket = -1): bool
    {
    }

    public function sendto(string $ip, int $port, string $data, int $serverSocket = -1): bool
    {
    }

    public function sendwait(int $fd, string $data): bool
    {
    }

    public function exists(int $fd): bool
    {
    }

    public function protect(int $fd, bool $isProtected = true): bool
    {
    }

    public function sendfile(int $fd, string $fileName, int $offset = 0, int $length = 0): bool
    {
    }

    public function close(int $fd, bool $reset = false): bool
    {
    }

    public function confirm(int $fd): bool
    {
    }

    public function pause(int $fd): bool
    {
    }

    public function resume(int $fd): bool
    {
    }

    public function reload(): bool
    {
    }

    public function shutdown(): bool
    {
    }

    /**
     * @param mixed $data
     * @return bool|int
     */
    public function task($data, int $workerId = -1, ?callable $finishCallback = null)
    {
    }

    /**
     * @param mixed $data
     * @return bool|string
     */
    public function taskwait($data, float $timeout = 0.5, int $workerId = -1)
    {
    }

    /**
     * @return bool|array
     */
    public function taskWaitMulti(array $tasks, float $timeout = 0.5)
    {
    }

    /**
     * @return bool|array
     */
    public function taskCo(array $tasks, float $timeout = 0.5)
    {
    }

    /**
     * @param mixed $data
     */
    public function finish($data): bool
    {
    }

    public function stop(int $workerId, bool $waitEvent = false): bool
    {
    }

    public function getLastError(): int
    {
    }

    /**
     * @return false|array
     */
    public function heartbeat(bool $closeConn = false)
    {
    }

    /**
     * @return bool|array
     */
    public function getClientInfo(int $fd, int $reactorId = -1, bool $noCheckConn = false)
    {
    }

    /**
     * @return bool|array
     */
    public function getClientList(int $startFd = 0, int $pageSize = 10)
    {
    }

    public function getWorkerId(): int
    {
    }

    /**
     * @return int|false
     */
    public function getWorkerPid(int $workerId = -1)
    {
    }

    /**
     * @return bool|int
     */
    public function getWorkerStatus(int $workerId = -1)
    {
    }

    public function getManagerPid(): int
    {
    }

    public function getMasterPid(): int
    {
    }

    /**
     * @return bool|array
     */
    public function connection_info(int $fd, int $reactorId = -1, bool $noCheckConn = false)
    {
    }

    /**
     * @return bool|array
     */
    public function connection_list(int $startFd = 0, int $pageSize = 10)
    {
    }

    /**
     * @param mixed $message
     */
    public function sendMessage($message, int $workerId): bool
    {
    }

    /**
     * @return bool|int
     */
    public function addProcess(Process $process)
    {
    }

    /**
     * @return string|array|false
     */
    public function stats(int $mode = 0)
    {
    }

    /**
     * @return mixed
     */
    public function getSocket(int $port = -1)
    {
    }

    public function bind(int $fd, int $uid): bool
    {
    }

    public function after(int $ms, callable $callback): void
    {
    }

    public function tick(int $ms, callable $callback): void
    {
    }

    public function clearTimer(): void
    {
    }

    public function defer(callable $callback): void
    {
    }
}

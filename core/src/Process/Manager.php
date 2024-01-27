<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Process;

use OpenSwoole\Process\Pool;

class Manager
{
    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @var int
     */
    protected $ipcType = SWOOLE_IPC_NONE;

    /**
     * @var int
     */
    protected $msgQueueKey = 0;

    /**
     * @var array
     */
    protected $startFuncMap = [];

    public function __construct(int $ipcType = SWOOLE_IPC_NONE, int $msgQueueKey = 0)
    {
        $this->setIPCType($ipcType)->setMsgQueueKey($msgQueueKey);
    }

    public function add(callable $func, bool $enableCoroutine = false): self
    {
        $this->addBatch(1, $func, $enableCoroutine);
        return $this;
    }

    public function addBatch(int $workerNum, callable $func, bool $enableCoroutine = false): self
    {
        for ($i = 0; $i < $workerNum; $i++) {
            $this->startFuncMap[] = [$func, $enableCoroutine];
        }
        return $this;
    }

    public function start(): void
    {
        $this->pool = new Pool(count($this->startFuncMap), $this->ipcType, $this->msgQueueKey, false);

        $this->pool->on(\OpenSwoole\Constant::EVENT_WORKER_START, function (Pool $pool, int $workerId) {
            [$func, $enableCoroutine] = $this->startFuncMap[$workerId];
            if ($enableCoroutine) {
                \OpenSwoole\Coroutine::run($func, $pool, $workerId);
            } else {
                $func($pool, $workerId);
            }
        });

        $this->pool->start();
    }

    public function setIPCType(int $ipcType): self
    {
        $this->ipcType = $ipcType;
        return $this;
    }

    public function getIPCType(): int
    {
        return $this->ipcType;
    }

    public function setMsgQueueKey(int $msgQueueKey): self
    {
        $this->msgQueueKey = $msgQueueKey;
        return $this;
    }

    public function getMsgQueueKey(): int
    {
        return $this->msgQueueKey;
    }
}

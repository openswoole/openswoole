<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Pool;

use co;
use OpenSwoole\Coroutine;
use OpenSwoole\Coroutine\Channel;

class ClientPool
{
    public const DEFAULT_SIZE = 16;

    private $pool;

    private $size;

    private $num;

    private $active;

    private $factory;

    private $config;

    public function __construct($factory, $config, int $size = self::DEFAULT_SIZE, bool $heartbeat = false)
    {
        $this->pool    = new Channel($this->size = $size);
        $this->num     = 0;
        $this->factory = $factory;
        $this->config  = $config;
        if ($heartbeat) {
            $this->heartbeat();
        }
    }

    public function fill(): void
    {
        while ($this->size > $this->num) {
            $this->make();
        }
    }

    public function get(float $timeout = -1)
    {
        if ($this->pool->isEmpty() && $this->num < $this->size) {
            $this->make();
        }

        $this->active++;

        return $this->pool->pop($timeout);
    }

    public function put($connection, $isNew = false): void
    {
        if ($this->pool === null) {
            return;
        }
        if ($connection !== null) {
            $this->pool->push($connection);

            if (!$isNew) {
                $this->active--;
            }
        } else {
            $this->num -= 1;
            $this->make();
        }
    }

    public function close()
    {
        if (!$this->pool) {
            return false;
        }
        while (1) {
            if ($this->active > 0) {
                co::sleep(1);
                continue;
            }
            if (!$this->pool->isEmpty()) {
                $client = $this->pool->pop();
                $client->close();
            } else {
                break;
            }
        }

        $this->pool->close();
        $this->pool = null;
        $this->num  = 0;
    }

    protected function make()
    {
        $this->num++;
        $client = $this->factory::make($this->config);
        $this->put($client, true);
    }

    protected function heartbeat()
    {
        Coroutine::create(function () {
            while ($this->pool) {
                co::sleep(3);
                $client = $this->get();
                $client->heartbeat();
                $this->put($client);
            }
        });
    }
}

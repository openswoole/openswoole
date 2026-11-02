<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection;

use Closure;
use OpenSwoole\Injection\Exceptions\ContainerClosedException;
use Psr\Container\ContainerInterface;
use Throwable;

class Scope implements ContainerInterface
{
    private ServiceProvider $provider;

    private int $contextId;

    private bool $bound;

    private bool $closed = false;

    /** @var array<string, object> */
    private array $instances = [];

    /** @var array<int, array{instance: object, disposer: Closure|null}> */
    private array $order = [];

    public function __construct(ServiceProvider $provider, int $contextId, bool $bound = true)
    {
        $this->provider  = $provider;
        $this->contextId = $contextId;
        $this->bound     = $bound;
    }

    public function get(string $id): object
    {
        if ($this->closed) {
            throw new ContainerClosedException("Cannot resolve {$id}: this scope has been closed");
        }
        return $this->provider->make($id, $this);
    }

    public function has(string $id): bool
    {
        return $this->provider->has($id);
    }

    public function isClosed(): bool
    {
        return $this->closed;
    }

    public function hasCached(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public function getCached(string $id): object
    {
        return $this->instances[$id];
    }

    public function store(string $id, object $instance, ?Closure $disposer): void
    {
        $this->instances[$id] = $instance;
        $this->order[]        = ['instance' => $instance, 'disposer' => $disposer];
    }

    public function close(): void
    {
        if ($this->closed) {
            return;
        }
        $this->closed = true;
        $error        = null;
        for ($i = count($this->order) - 1; $i >= 0; $i--) {
            try {
                $this->provider->dispose($this->order[$i]['instance'], $this->order[$i]['disposer']);
            } catch (Throwable $e) {
                $error ??= $e;
            }
        }
        $this->instances = [];
        $this->order     = [];
        if ($this->bound) {
            $this->provider->detachScope($this, $this->contextId);
        }
        if ($error) {
            throw $error;
        }
    }
}

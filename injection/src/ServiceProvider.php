<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection;

use Closure;
use OpenSwoole\Injection\Exceptions\CircularDependencyException;
use OpenSwoole\Injection\Exceptions\ContainerClosedException;
use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use OpenSwoole\Injection\Exceptions\NotFoundException;
use OpenSwoole\Injection\Exceptions\ResolutionException;
use OpenSwoole\Injection\Exceptions\ScopeViolationException;
use OpenSwoole\Injection\Metadata\ServiceDefinition;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;
use Throwable;

class ServiceProvider implements ContainerInterface
{
    /** @var array<string, ServiceDefinition> */
    private array $definitions;

    /** @var array<string, object> */
    private array $singletons = [];

    /** @var string[] */
    private array $singletonOrder = [];

    /** @var array<int, Scope[]> */
    private array $scopeStack = [];

    /** @var array<int, array<int, array{id: string, lifetime: string}>> */
    private array $resolving = [];

    private bool $closed = false;

    private ?int $contextStrategy = null;

    /** @param array<string, ServiceDefinition> $definitions */
    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    public function isClosed(): bool
    {
        return $this->closed;
    }

    public function has(string $id): bool
    {
        // A true result does not guarantee get() will succeed: an abstract
        // class or unbound interface can still be non-instantiable.
        return isset($this->definitions[$id])
            || isset($this->singletons[$id])
            || class_exists($id)
            || interface_exists($id);
    }

    public function get(string $id): object
    {
        return $this->make($id, $this->currentScope());
    }

    public function createScope(bool $bind = true): Scope
    {
        $this->assertOpen();
        $id    = $this->contextId();
        $scope = new Scope($this, $id, $bind);
        if ($bind) {
            $this->scopeStack[$id][] = $scope;
        }
        return $scope;
    }

    public function currentScope(): ?Scope
    {
        $s = $this->scopeStack[$this->contextId()] ?? [];
        return $s ? $s[count($s) - 1] : null;
    }

    public function close(): void
    {
        if ($this->closed) {
            return;
        }
        $this->closed = true;
        $error        = null;
        foreach ($this->scopeStack as $scopes) {
            foreach (array_reverse($scopes) as $scope) {
                try {
                    $scope->close();
                } catch (Throwable $e) {
                    $error ??= $e;
                }
            }
        }
        foreach (array_reverse($this->singletonOrder) as $id) {
            try {
                if (isset($this->singletons[$id])) {
                    $this->dispose($this->singletons[$id], $this->definitions[$id]->disposer);
                }
            } catch (Throwable $e) {
                $error ??= $e;
            }
        }
        $this->scopeStack     = [];
        $this->singletons     = [];
        $this->singletonOrder = [];
        if ($error) {
            throw $error;
        }
    }

    /** @internal */
    public function make(string $id, ?Scope $scope): object
    {
        $this->assertOpen();
        $definition = $this->definitions[$id] ?? null;
        $lifetime   = $definition ? $definition->lifetime : Lifetime::SINGLETON;
        if ($lifetime === Lifetime::SINGLETON && isset($this->singletons[$id])) {
            return $this->singletons[$id];
        }
        $this->assertNotCaptured($id, $lifetime);
        if ($lifetime === Lifetime::SCOPED) {
            if ($scope === null) {
                throw new ScopeViolationException("Cannot resolve scoped service {$id} without an active scope; call ServiceProvider::createScope() first");
            }
            if ($scope->hasCached($id)) {
                return $scope->getCached($id);
            }
        }
        $exists   = $definition !== null || class_exists($id);
        $concrete = $definition ? $definition->concrete : $id;
        $this->start($id, $lifetime);
        try {
            $object = $this->build($id, $concrete, $lifetime === Lifetime::SINGLETON ? null : $scope);
            if ($lifetime === Lifetime::SINGLETON) {
                $this->singletonOrder[]       = $id;
                return $this->singletons[$id] = $object;
            }
            if ($lifetime === Lifetime::SCOPED) {
                $scope->store($id, $object, $definition ? $definition->disposer : null);
                return $object;
            }
            return $object;
        } catch (NotFoundException $e) {
            if (!$exists) {
                throw $e;
            } throw new ResolutionException("Unable to resolve service {$id}: {$e->getMessage()}", 0, $e);
        } finally {
            $this->stop();
        }
    }

    /** @internal */
    public function dispose(object $instance, ?Closure $disposer): void
    {
        if ($disposer) {
            $disposer($instance);
        } elseif ($instance instanceof Disposable) {
            $instance->dispose();
        }
    }

    /** @internal */
    public function detachScope(Scope $scope, int $contextId): void
    {
        $stack = $this->scopeStack[$contextId] ?? [];
        foreach ($stack as $i => $candidate) {
            if ($candidate === $scope) {
                unset($stack[$i]);
            }
        } $stack = array_values($stack);
        if ($stack) {
            $this->scopeStack[$contextId] = $stack;
        } else {
            unset($this->scopeStack[$contextId]);
        }
    }

    private function assertOpen(): void
    {
        if ($this->closed) {
            throw new ContainerClosedException('The service provider has been closed and can no longer resolve services or create scopes');
        }
    }

    private function assertNotCaptured(string $id, string $lifetime): void
    {
        if ($lifetime !== Lifetime::SCOPED) {
            return;
        } foreach (array_reverse($this->resolving[$this->contextId()] ?? []) as $entry) {
            if ($entry['lifetime'] === Lifetime::SINGLETON) {
                throw new ScopeViolationException("Cannot resolve scoped service {$id} while building singleton {$entry['id']}; register {$entry['id']} as scoped or transient");
            }
        }
    }

    private function start(string $id, string $lifetime): void
    {
        $key   = $this->contextId();
        $stack = $this->resolving[$key] ?? [];
        foreach ($stack as $i => $e) {
            if ($e['id'] === $id) {
                $cycle   = array_column(array_slice($stack, $i), 'id');
                $cycle[] = $id;
                throw new CircularDependencyException('Circular dependency detected: ' . implode(' -> ', $cycle));
            }
        } $stack[]             = ['id' => $id, 'lifetime' => $lifetime];
        $this->resolving[$key] = $stack;
    }

    private function stop(): void
    {
        $key = $this->contextId();
        if (isset($this->resolving[$key])) {
            array_pop($this->resolving[$key]);
            if (!$this->resolving[$key]) {
                unset($this->resolving[$key]);
            }
        }
    }

    private function build(string $id, $concrete, ?Scope $scope): object
    {
        if ($concrete instanceof Closure) {
            $object = $concrete($scope ?? $this);
            if (!is_object($object)) {
                throw new DependencyIsNotInstantiableException("Factory for {$id} must return an object, got " . gettype($object));
            } return $object;
        } return $this->resolve($concrete, $scope);
    }

    private function resolve(string $class, ?Scope $scope): object
    {
        try {
            $r = new ReflectionClass($class);
        } catch (ReflectionException $e) {
            throw new NotFoundException("Class {$class} does not exist", 0, $e);
        } if (!$r->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class {$class} is not instantiable");
        } $c = $r->getConstructor();
        if (!$c) {
            return $r->newInstance();
        } $args = [];
        foreach ($c->getParameters() as $p) {
            $args[] = $this->dependency($p, $scope);
        } return $r->newInstance(...$args);
    }

    private function dependency(ReflectionParameter $p, ?Scope $scope)
    {
        $type = $p->getType();
        if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
            if ($p->isDefaultValueAvailable()) {
                return $p->getDefaultValue();
            } throw new DependencyHasNoDefaultValueException('Cannot resolve parameter $' . $p->getName() . ' without a default value');
        }

        // Optional class dependencies may legitimately be unavailable. When a
        // default value exists (for example, `?LoggerInterface $logger = null`),
        // use it instead of failing the entire construction.
        try {
            return $this->make($type->getName(), $scope);
        } catch (NotFoundException|DependencyIsNotInstantiableException|ResolutionException $exception) {
            if ($p->isDefaultValueAvailable()) {
                return $p->getDefaultValue();
            }

            throw $exception;
        }
    }

    private function contextId(): int
    {
        if ($this->contextStrategy === null) {
            $this->contextStrategy = class_exists('\OpenSwoole\Coroutine') && method_exists('\OpenSwoole\Coroutine', 'getCid') ? 1 : 0;
        } return $this->contextStrategy ? max(0, \OpenSwoole\Coroutine::getCid()) : 0;
    }
}

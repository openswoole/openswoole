<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection;

use Closure;
use InvalidArgumentException;
use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use OpenSwoole\Injection\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

class Container implements ContainerInterface
{
    public const LIFETIME_SINGLETON = 'singleton';

    public const LIFETIME_TRANSIENT = 'transient';

    private const CONTEXT_NONE = 0;

    private const CONTEXT_OPENSWOOLE = 1;

    /**
     * Registered bindings: id => concrete class-string or factory Closure.
     *
     * @var array<string, string|Closure>
     */
    private array $bindings = [];

    /**
     * Resolved singleton instances, keyed by id.
     *
     * @var array<string, object>
     */
    private array $instances = [];

    /**
     * Registered lifetimes, keyed by id.
     *
     * @var array<string, string>
     */
    private array $lifetimes = [];

    /**
     * Resolution stacks used to detect circular dependencies, keyed by coroutine id.
     *
     * @var array<int, string[]>
     */
    private array $resolving = [];

    private ?int $contextStrategy = null;

    /**
     * @throws CircularDependencyException
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws NotFoundException
     */
    public function get(string $id): object
    {
        $lifetime = $this->lifetimes[$id] ?? self::LIFETIME_SINGLETON;

        // Return the already-resolved singleton if we have one.
        if ($lifetime === self::LIFETIME_SINGLETON && isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        // Fall back to the id itself as the concrete when nothing is bound.
        $concrete = $this->bindings[$id] ?? $id;

        $this->startResolving($id);
        try {
            $object = $this->build($id, $concrete);

            if ($lifetime === self::LIFETIME_SINGLETON) {
                return $this->instances[$id] = $object;
            }

            return $object;
        } finally {
            $this->stopResolving();
        }
    }

    /**
     * Bind an id to a concrete class-string or factory Closure as a singleton.
     *
     * @param string|Closure|null $concrete
     */
    public function set(string $id, $concrete = null): void
    {
        $this->singleton($id, $concrete);
    }

    /**
     * Bind an id to a concrete class-string or factory Closure as a singleton.
     *
     * @param string|Closure|null $concrete
     */
    public function singleton(string $id, $concrete = null): void
    {
        $this->bind($id, $concrete, self::LIFETIME_SINGLETON);
    }

    /**
     * Bind an id to a concrete class-string or factory Closure as transient.
     *
     * @param string|Closure|null $concrete
     */
    public function transient(string $id, $concrete = null): void
    {
        $this->bind($id, $concrete, self::LIFETIME_TRANSIENT);
    }

    public function has(string $id): bool
    {
        // Explicitly bound, already resolved, or autowirable as a concrete class.
        return isset($this->bindings[$id])
            || isset($this->instances[$id])
            || class_exists($id);
    }

    /**
     * @param string|Closure|null $concrete
     */
    private function bind(string $id, $concrete, string $lifetime): void
    {
        if ($concrete !== null && !is_string($concrete) && !$concrete instanceof Closure) {
            $type = is_object($concrete) ? get_class($concrete) : gettype($concrete);

            throw new InvalidArgumentException("Concrete binding for {$id} must be a class-string, Closure, or null; got {$type}");
        }

        $this->bindings[$id]  = $concrete ?? $id;
        $this->lifetimes[$id] = $lifetime;

        // Drop any previously-resolved singleton so the next get() rebuilds
        // from the new binding instead of returning the stale instance.
        unset($this->instances[$id]);
    }

    /**
     * @param string|Closure $concrete
     * @throws CircularDependencyException
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws NotFoundException
     */
    private function build(string $id, $concrete): object
    {
        if ($concrete instanceof Closure) {
            $object = $concrete($this);

            // A factory must produce an object; otherwise the bad value would
            // surface later as the get() return-type error.
            if (!is_object($object)) {
                throw new DependencyIsNotInstantiableException("Factory for {$id} must return an object, got " . gettype($object));
            }

            return $object;
        }

        return $this->resolve($concrete);
    }

    /**
     * @throws CircularDependencyException
     */
    private function startResolving(string $id): void
    {
        $contextId = $this->getContextId();
        $stack     = $this->resolving[$contextId] ?? [];
        $index     = array_search($id, $stack, true);
        if ($index !== false) {
            $cycle   = array_slice($stack, $index);
            $cycle[] = $id;

            throw new CircularDependencyException('Circular dependency detected: ' . implode(' -> ', $cycle));
        }

        $stack[]                     = $id;
        $this->resolving[$contextId] = $stack;
    }

    private function stopResolving(): void
    {
        $contextId = $this->getContextId();
        if (!isset($this->resolving[$contextId])) {
            return;
        }

        array_pop($this->resolving[$contextId]);
        if ($this->resolving[$contextId] === []) {
            unset($this->resolving[$contextId]);
        }
    }

    private function getContextId(): int
    {
        if ($this->contextStrategy === null) {
            $this->contextStrategy = $this->detectContextStrategy();
        }

        if ($this->contextStrategy === self::CONTEXT_OPENSWOOLE) {
            $cid = \OpenSwoole\Coroutine::getCid();

            return $cid > 0 ? $cid : 0;
        }

        return 0;
    }

    private function detectContextStrategy(): int
    {
        if (class_exists('\OpenSwoole\Coroutine') && method_exists('\OpenSwoole\Coroutine', 'getCid')) {
            return self::CONTEXT_OPENSWOOLE;
        }

        return self::CONTEXT_NONE;
    }

    /**
     * @throws CircularDependencyException
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws NotFoundException
     */
    private function resolve(string $concrete): object
    {
        // Reflection
        try {
            $reflection = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new NotFoundException("Class {$concrete} does not exist", 0, $e);
        }

        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class {$concrete} is not instantiable");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $parameters   = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);
        return $reflection->newInstance(...$dependencies);
    }

    /**
     * @throws CircularDependencyException
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws NotFoundException
     */
    private function getDependencies(array $parameters): array
    {
        // Autowired
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyHasNoDefaultValueException('Cannot resolve class dependency ' . $parameter->name);
                }
            } else {
                // Recursively get dependencies
                $dependencies[] = $this->get($type->getName());
            }
        }
        return $dependencies;
    }
}

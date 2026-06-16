<?php

declare(strict_types=1);

namespace OpenSwoole\Injection;

use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use OpenSwoole\Injection\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use Closure;

class Container implements ContainerInterface
{

    private array $bindings = [];
    private array $instances = [];

    /**
     * @param string $id
     * @return object
     * @throws NotFoundException
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     */
    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $concrete = $this->bindings[$id] ?? $id;

        if ($concrete instanceof Closure)
        {
            $object = $concrete($this);

            // A factory must produce an object; otherwise the bad value would
            // be cached and only surface later as the get() return-type error.
            if (!is_object($object))
            {
                throw new DependencyIsNotInstantiableException(
                    "Factory for {$id} must return an object, got " . gettype($object)
                );
            }
        }
        else
        {
            $object = $this->resolve($concrete);
        }


        return $this->instances[$id] = $object;
    }

    public function set(string $id, string|Closure|null $concrete = null): void
    {
        $this->bindings[$id] = $concrete ?? $id;

        // Drop any previously-resolved singleton so the next get() rebuilds
        // from the new binding instead of returning the stale instance.
        unset($this->instances[$id]);

    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        // Explicitly bound, already resolved, or autowirable as a concrete class.
        return isset($this->bindings[$id])
            || isset($this->instances[$id])
            || class_exists($id);

    }

    /**
     * @param string $concrete
     * @return object
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws NotFoundException
     */
    private function resolve(string $concrete): object
    {
        // Reflection
        try
        {
            $reflection = new ReflectionClass($concrete);
        }
        catch (ReflectionException $e)
        {
            throw new NotFoundException("Class {$concrete} does not exist", 0, $e);
        }

        if(!$reflection->isInstantiable())
        {
            throw new DependencyIsNotInstantiableException("Class {$concrete} is not instantiable");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);
        return $reflection->newInstance(...$dependencies);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws NotFoundException
     */
    private function getDependencies(array $parameters): array
    {
        // Autowired
        $dependencies = [];
        foreach ($parameters as $parameter)
        {
            $type = $parameter->getType();
            if (!$type instanceof \ReflectionNamedType || $type->isBuiltin())
            {
                if($parameter->isDefaultValueAvailable())
                {
                    $dependencies[] = $parameter->getDefaultValue();
                }
                else
                {
                    throw new DependencyHasNoDefaultValueException("Cannot resolve class dependency " . $parameter->name);
                }
            }
            else
            {
                // Recursively get dependencies
                $dependencies[] = $this->get($type->getName());
            }
        }
        return $dependencies;
    }
}
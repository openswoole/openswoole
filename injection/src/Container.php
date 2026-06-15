<?php

declare(strict_types=1);

namespace OpenSwoole\Injection;

use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
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
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $concrete = $this->bindings[$id] ?? $id;

        $object = $concrete instanceof Closure
            ? $concrete($this)
            : $this->resolve($concrete);

        return $this->instances[$id] = $object;
    }

    public function set(string $id, string|Closure|null $concrete = null): void
    {
        $this->bindings[$id] = $concrete ?? $id;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]) || isset($this->instances[$id]);
    }

    /**
     * @param string $concrete
     * @return object
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    private function resolve(string $concrete): object
    {
        // Reflection
        $reflection = new ReflectionClass($concrete);
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
     * @throws ReflectionException
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
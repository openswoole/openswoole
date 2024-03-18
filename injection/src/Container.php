<?php

declare(strict_types=1);

namespace OpenSwoole\Injection;

use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{

    private array $instance = [];

    /**
     * @param string $id
     * @return object
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    public function get(string $id): object
    {
        if(!$this->has($id))
        {
            $this->set($id);
        }
        $concrete = $this->instance[$id];
        return $this->resolve($concrete);
    }

    public function set($id, $concrete = null)
    {
        $this->instance[$id] = $concrete ?? $id;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instance[$id]);
    }

    /**
     * @param $concrete
     * @return object
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    private function resolve($concrete): object
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
        $dependencies = $this->getDependencies($parameters, $reflection);
        return $reflection->newInstance(...$dependencies);
    }

    /**
     * @param array $parameters
     * @param ReflectionClass $reflection
     * @return array
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    private function getDependencies(array $parameters, ReflectionClass $reflection): array
    {
        // Autowired
        $dependencies = [];
        foreach ($parameters as $parameter)
        {
            $dependency = $parameter->getClass();
            if (is_null($dependency))
            {
                if($parameter->isDefaultValueAvaliable())
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
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }
}
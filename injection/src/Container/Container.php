<?php

declare(strict_types=1);

namespace OpenSwoole\Injection;

use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{

    private array $instance = [];
    /**
     * @param string $id
     * @return mixed
     */
    public function get(string $id)
    {
        $concrete = $this->instance[$id];
        return $this->resolve($concrete);
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
     * @throws DependencyIsNotInstantiableException
     * @throws ReflectionException
     */
    private function resolve($concrete)
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
        return $reflection->newInstance($dependencies);
    }

    /**
     * @throws DependencyHasNoDefaultValueException
     */
    private function getDependencies(array $parameters, ReflectionClass $reflection)
    {
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
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }
}
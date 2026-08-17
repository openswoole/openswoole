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
use OpenSwoole\Injection\Metadata\ServiceDefinition;
use OpenSwoole\Injection\Scanner\ServiceParserInterface;
use OpenSwoole\Injection\Scanner\ServiceScanner;

class ServiceCollection
{
    /** @var array<string, ServiceDefinition> */
    private array $definitions = [];

    /** @param string|Closure|null $concrete */
    public function singleton(string $id, $concrete = null, ?Closure $disposer = null): self
    {
        return $this->register($id, $concrete, Lifetime::SINGLETON, $disposer);
    }

    /** @param string|Closure|null $concrete */
    public function set(string $id, $concrete = null, ?Closure $disposer = null): self
    {
        return $this->singleton($id, $concrete, $disposer);
    }

    /** @param string|Closure|null $concrete */
    public function scoped(string $id, $concrete = null, ?Closure $disposer = null): self
    {
        return $this->register($id, $concrete, Lifetime::SCOPED, $disposer);
    }

    /** @param string|Closure|null $concrete */
    public function transient(string $id, $concrete = null): self
    {
        return $this->register($id, $concrete, Lifetime::TRANSIENT, null);
    }

    /** @param ServiceParserInterface[] $parsers */
    public function scan(string $directory, string $namespace, array $parsers = []): self
    {
        foreach ((new ServiceScanner($parsers))->scan($directory, $namespace) as $definition) {
            $this->register($definition->id, $definition->concrete, $definition->lifetime, $definition->disposer);
        }
        return $this;
    }

    public function build(): ServiceProvider
    {
        return new ServiceProvider($this->definitions);
    }

    /** @param string|Closure|null $concrete */
    private function register(string $id, $concrete, string $lifetime, ?Closure $disposer): self
    {
        if ($concrete !== null && !is_string($concrete) && !$concrete instanceof Closure) {
            $type = is_object($concrete) ? get_class($concrete) : gettype($concrete);
            throw new InvalidArgumentException("Concrete binding for {$id} must be a class-string, Closure, or null; got {$type}");
        }
        $this->definitions[$id] = new ServiceDefinition($id, $concrete ?? $id, $lifetime, $disposer);
        return $this;
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Client;

use Error;
use TypeError;

class ClientProxy
{
    protected object $__object;

    public function __construct($object)
    {
        if (!is_object($object)) {
            throw new TypeError('Non-object given');
        }
        $this->__object = $object;
    }

    public function __getObject(): object
    {
        return $this->__object;
    }

    public function __get(string $name)
    {
        return $this->__object->{$name};
    }

    public function __set(string $name, $value): void
    {
        $this->__object->{$name} = $value;
    }

    public function __isset($name): bool
    {
        return isset($this->__object->{$name});
    }

    public function __unset(string $name): void
    {
        unset($this->__object->{$name});
    }

    public function __call(string $name, array $arguments)
    {
        return $this->__object->{$name}(...$arguments);
    }

    public function __invoke(...$arguments)
    {
        $object = $this->__object;
        return $object(...$arguments);
    }

    public function __clone()
    {
        throw new Error('Trying to clone an uncloneable object proxy object');
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

final class Context implements ContextInterface, \IteratorAggregate, \Countable, \ArrayAccess
{
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function withValue(string $key, $value): ContextInterface
    {
        $context               = clone $this;
        $context->values[$key] = $value;
        return $context;
    }

    public function getValue(string $key, $default = null)
    {
        return $this->values[$key] ?? $default;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function offsetExists($offset): bool
    {
        assert(\is_string($offset), 'Offset argument must be a type of string');

        return isset($this->values[$offset]) || \array_key_exists($offset, $this->values);
    }

    public function offsetGet($offset)
    {
        assert(\is_string($offset), 'Offset argument must be a type of string');

        return $this->values[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        assert(\is_string($offset), 'Offset argument must be a type of string');

        $this->values[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        assert(\is_string($offset), 'Offset argument must be a type of string');

        unset($this->values[$offset]);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->values);
    }

    public function count(): int
    {
        return \count($this->values);
    }
}

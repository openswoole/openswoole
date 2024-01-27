<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Connection;

use ArrayAccess;
use Countable;

class Iterator implements \Iterator, ArrayAccess, Countable
{
    public function __construct() {}

    public function __destruct() {}

    public function rewind() {}

    public function next() {}

    public function current() {}

    public function key() {}

    public function valid() {}

    public function count() {}

    /**
     * @param mixed $key [required]
     */
    public function offsetExists($key) {}

    /**
     * @param mixed $key [required]
     */
    public function offsetGet($key) {}

    /**
     * @param mixed $key [required]
     * @param mixed $value [required]
     */
    public function offsetSet($key, $value) {}

    /**
     * @param mixed $key [required]
     */
    public function offsetUnset($key) {}
}

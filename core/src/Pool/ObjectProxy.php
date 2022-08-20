<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Core\Pool;

use Error;

class ObjectProxy extends \Swoole\ObjectProxy
{
    public function __clone()
    {
        throw new Error('Trying to clone an uncloneable database proxy object');
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine;

use ArrayObject;

class Context extends ArrayObject
{
    public const STD_PROP_LIST = 1;

    public const ARRAY_AS_PROPS = 2;
}

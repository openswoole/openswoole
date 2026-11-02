<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Metadata;

use Closure;

class ServiceDefinition
{
    public string $id;

    /** @var string|Closure */
    public $concrete;

    public ?Closure $disposer;

    public string $lifetime;

    /** @param string|Closure $concrete */
    public function __construct(string $id, $concrete, string $lifetime, ?Closure $disposer = null)
    {
        $this->id       = $id;
        $this->concrete = $concrete;
        $this->lifetime = $lifetime;
        $this->disposer = $disposer;
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Metadata;

class ServiceDefinition
{
    public string $id;

    public string $concrete;

    public string $lifetime;

    public function __construct(string $id, string $concrete, string $lifetime)
    {
        $this->id       = $id;
        $this->concrete = $concrete;
        $this->lifetime = $lifetime;
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Attributes;

use Attribute;
use InvalidArgumentException;
use OpenSwoole\Injection\Lifetime;

#[Attribute(Attribute::TARGET_CLASS)]
final class Service
{
    public string $lifetime;

    public function __construct(string $lifetime = Lifetime::SINGLETON)
    {
        if (!in_array($lifetime, Lifetime::validLifetimes(), true)) {
            throw new InvalidArgumentException("Unknown lifetime \"{$lifetime}\" in #[Service] attribute. " . 'Expected one of: ' . implode(', ', Lifetime::validLifetimes()));
        }

        $this->lifetime = $lifetime;
    }
}

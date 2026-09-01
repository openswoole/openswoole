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

/**
 * Marks a class for registration by ServiceCollection::scan().
 *
 * Requires PHP 8.0+. On PHP 7.4 use the @Service docblock instead; this class
 * must not be imported or loaded under PHP 7.4.
 *
 * @see \OpenSwoole\Injection\Scanner\DocBlockServiceParser
 */

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

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
use OpenSwoole\Injection\Container;

#[Attribute(Attribute::TARGET_CLASS)]
final class Service
{
    public string $lifetime;

    public function __construct(string $lifetime = Container::LIFETIME_SINGLETON)
    {
        if (!in_array($lifetime, self::validLifetimes(), true)) {
            throw new InvalidArgumentException("Unknown lifetime \"{$lifetime}\" in #[Service] attribute. " . 'Expected one of: ' . implode(', ', self::validLifetimes()));
        }

        $this->lifetime = $lifetime;
    }

    /**
     * @return string[]
     */
    private static function validLifetimes(): array
    {
        return [
            Container::LIFETIME_SINGLETON,
            Container::LIFETIME_TRANSIENT,
            Container::LIFETIME_SCOPED,
        ];
    }
}

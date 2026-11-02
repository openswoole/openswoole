<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection;

final class Lifetime
{
    public const SINGLETON = 'singleton';

    public const SCOPED = 'scoped';

    public const TRANSIENT = 'transient';

    /** @return string[] */
    public static function validLifetimes(): array
    {
        return [self::SINGLETON, self::SCOPED, self::TRANSIENT];
    }
}

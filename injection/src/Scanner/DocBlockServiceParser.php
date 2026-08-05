<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Scanner;

use InvalidArgumentException;
use OpenSwoole\Injection\Container;
use OpenSwoole\Injection\Metadata\ServiceDefinition;
use ReflectionClass;

class DocBlockServiceParser implements ServiceParserInterface
{
    private const VALID_LIFETIMES = [
        Container::LIFETIME_SINGLETON,
        Container::LIFETIME_TRANSIENT,
        Container::LIFETIME_SCOPED,
    ];

    public function parse(ReflectionClass $reflection): ?ServiceDefinition
    {
        $docblock = $reflection->getDocComment();
        if ($docblock === false) {
            return null;
        }

        return $this->parseDocblock($reflection->getName(), $docblock);
    }

    private function parseDocblock(string $fqcn, string $docblock): ?ServiceDefinition
    {
        if (preg_match('/@Service\b(?:\s*\(([^)]*)\))?(?!\s*\()/', $docblock, $matches) !== 1) {
            return null;
        }

        $lifetime = $this->parseLifetime($fqcn, isset($matches[1]) ? trim($matches[1]) : '');

        if (!in_array($lifetime, self::VALID_LIFETIMES, true)) {
            throw new InvalidArgumentException("Unknown lifetime \"{$lifetime}\" in @Service annotation on {$fqcn}. " . 'Expected one of: ' . implode(', ', self::VALID_LIFETIMES));
        }

        return new ServiceDefinition($fqcn, $fqcn, $lifetime);
    }

    private function parseLifetime(string $fqcn, string $argument): string
    {
        if ($argument === '') {
            return Container::LIFETIME_SINGLETON;
        }

        if (preg_match('/^(?:lifetime\s*=\s*)?["\']([^"\']+)["\']$/', $argument, $matches) === 1) {
            return $matches[1];
        }

        throw new InvalidArgumentException("Invalid @Service annotation on {$fqcn}. Expected @Service, @Service(\"scoped\"), " . 'or @Service(lifetime="scoped")');
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Scanner;

use OpenSwoole\Injection\Metadata\ServiceDefinition;
use ReflectionClass;

/**
 * Reads the native #[Service] attribute (PHP 8+).
 */
class AttributeServiceParser implements ServiceParserInterface
{
    public function parse(ReflectionClass $reflection): ?ServiceDefinition
    {
        if (!method_exists($reflection, 'getAttributes')) {
            return null;
        }

        $attrs = $reflection->getAttributes(\OpenSwoole\Injection\Attributes\Service::class);
        if (count($attrs) === 0) {
            return null;
        }

        $instance = $attrs[0]->newInstance();
        $fqcn     = $reflection->getName();

        return new ServiceDefinition($fqcn, $fqcn, $instance->lifetime);
    }
}

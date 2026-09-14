<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Scanner;

use OpenSwoole\Injection\Attributes\Service;
use OpenSwoole\Injection\Metadata\ServiceDefinition;
use ReflectionClass;

/**
 * Reads the native #[Service] attribute.
 */
class AttributeServiceParser implements ServiceParserInterface
{
    public function parse(ReflectionClass $reflection): ?ServiceDefinition
    {
        $attrs = $reflection->getAttributes(Service::class);
        if (count($attrs) === 0) {
            return null;
        }

        $instance = $attrs[0]->newInstance();
        $fqcn     = $reflection->getName();

        return new ServiceDefinition($fqcn, $fqcn, $instance->lifetime);
    }
}

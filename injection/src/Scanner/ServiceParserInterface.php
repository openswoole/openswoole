<?php

declare(strict_types=1);

namespace OpenSwoole\Injection\Scanner;

use OpenSwoole\Injection\Metadata\ServiceDefinition;
use ReflectionClass;

interface ServiceParserInterface
{
    /**
     * Return a ServiceDefinition if the class carries the marker this parser
     * understands, or null to let the next parser in the chain try.
     */
    public function parse(ReflectionClass $reflection): ?ServiceDefinition;
}

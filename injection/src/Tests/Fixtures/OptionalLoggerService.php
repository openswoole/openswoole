<?php

declare(strict_types=1);

namespace OpenSwoole\Injection\Tests\Fixtures;

class OptionalLoggerService
{
    public ?LoggerInterface $logger;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }
}

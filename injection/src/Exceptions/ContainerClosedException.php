<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

class ContainerClosedException extends RuntimeException implements ContainerExceptionInterface
{
}

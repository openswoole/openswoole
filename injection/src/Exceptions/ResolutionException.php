<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class ResolutionException extends Exception implements ContainerExceptionInterface
{
}

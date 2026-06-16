<?php

declare(strict_types=1);

namespace OpenSwoole\Injection\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class DependencyHasNoDefaultValueException
    extends Exception
    implements ContainerExceptionInterface
{

}
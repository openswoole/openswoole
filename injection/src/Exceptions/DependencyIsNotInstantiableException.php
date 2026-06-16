<?php

declare(strict_types=1);

namespace OpenSwoole\Injection\Exceptions;
use Psr\Container\ContainerExceptionInterface;

use Exception;

class DependencyIsNotInstantiableException extends Exception implements ContainerExceptionInterface
{

}
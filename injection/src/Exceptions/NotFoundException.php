<?php

declare(strict_types=1);

namespace OpenSwoole\Injection\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException
    extends Exception
    implements NotFoundExceptionInterface
{

}


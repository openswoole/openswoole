<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\GRPC\Exception;

use OpenSwoole\GRPC\Status;
use RuntimeException;
use Throwable;

class GRPCException extends RuntimeException
{
    protected const CODE = Status::UNKNOWN;

    final public function __construct(
        string $message = '',
        ?int $code = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, (int) ($code ?? static::CODE), $previous);
    }

    public static function create(
        string $message,
        ?int $code = null,
        ?Throwable $previous = null,
    ): self {
        return new static($message, $code, $previous);
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

final class Status
{
    public const OK = 0;

    public const CANCELLED = 1;

    public const UNKNOWN = 2;

    public const INVALID_ARGUMENT = 3;

    public const DEADLINE_EXCEEDED = 4;

    public const NOT_FOUND = 5;

    public const ALREADY_EXISTS = 6;

    public const PERMISSION_DENIED = 7;

    public const RESOURCE_EXHAUSTED = 8;

    public const FAILED_PRECONDITION = 9;

    public const ABORTED = 10;

    public const OUT_OF_RANGE = 11;

    public const UNIMPLEMENTED = 12;

    public const INTERNAL = 13;

    public const UNAVAILABLE = 14;

    public const DATA_LOSS = 15;

    public const UNAUTHENTICATED = 16;
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
# source: hello.proto

namespace Hello;

use OpenSwoole\GRPC;

interface StreamGreeterInterface extends GRPC\ServiceInterface
{
    public const NAME = '/hello.StreamGreeter';

    /**
     * @return iterable<HelloReply>
     *
     * @throws GRPC\Exception\InvokeException
     */
    public function Hello(GRPC\ContextInterface $ctx, HelloRequest $request): iterable;
}

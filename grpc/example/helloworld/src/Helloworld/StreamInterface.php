<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
# source: helloworld.proto

namespace Helloworld;

use OpenSwoole\GRPC;

interface StreamInterface extends GRPC\ServiceInterface
{
    public const NAME = '/helloworld.Stream';

    /**
     * @throws GRPC\Exception\InvokeException
     */
    public function FetchResponse(GRPC\ContextInterface $ctx, HelloRequest $request): HelloReply;
}

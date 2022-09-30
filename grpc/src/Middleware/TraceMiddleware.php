<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC\Middleware;

use OpenSwoole\GRPC\MessageInterface;
use OpenSwoole\GRPC\RequestHandlerInterface;

class TraceMiddleware implements MiddlewareInterface
{
    public function process(MessageInterface $request, RequestHandlerInterface $handler): MessageInterface
    {
        return $handler->handle($request);
    }
}

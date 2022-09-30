<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\GRPC\Middleware;

use OpenSwoole\Constant;
use OpenSwoole\GRPC\MessageInterface;
use OpenSwoole\GRPC\RequestHandlerInterface;
use OpenSwoole\Util;

class LoggingMiddleware implements MiddlewareInterface
{
    public function process(MessageInterface $request, RequestHandlerInterface $handler): MessageInterface
    {
        $service    = $request->getService();
        $method     = $request->getMethod();
        $context    = $request->getContext();
        $rawRequest = $context->getValue(\OpenSwoole\Http\Request::class);
        $client     = $rawRequest->server['remote_addr'] . ':' . $rawRequest->server['remote_port'];
        $server     = $rawRequest->header['host'];
        $streamId   = $rawRequest->streamId;
        $ua         = $rawRequest->header['user-agent'];
        Util::log(Constant::LOG_INFO, "GRPC request: {$client}->{$server}, stream({$streamId}), " . $service . '/' . $method . ', ' . $ua);
        return $handler->handle($request);
    }
}

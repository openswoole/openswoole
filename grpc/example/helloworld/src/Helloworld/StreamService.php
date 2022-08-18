<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace Helloworld;

use OpenSwoole\GRPC;

class StreamService implements StreamInterface
{
    /**
     * @throws GRPC\Exception\InvokeException
     */
    public function FetchResponse(GRPC\ContextInterface $ctx, HelloRequest $request): HelloReply
    {
        while (1) {
            $name = $request->getName();
            $out  = new HelloReply();
            $out->setMessage('hello ' . $name . time());

            $message = new GRPC\Message($ctx, $out);

            $ctx['WORKER_CONTEXT']->getValue(\OpenSwoole\GRPC\Server::class)->push($message);
            \Swoole\Coroutine::sleep(1);
        }
    }
}

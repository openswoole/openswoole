<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace Helloworld;

use OpenSwoole\GRPC;

class StreamService implements StreamInterface
{
    /**
     * @return iterable<HelloReply>
     * @throws GRPC\Exception\InvokeException
     */
    public function FetchResponse(GRPC\ContextInterface $ctx, HelloRequest $request): iterable
    {
        while (1) {
            $name = $request->getName();
            $out  = new HelloReply();
            $out->setMessage('hello ' . $name . time());

            yield $out;

            \Swoole\Coroutine::sleep(1);
        }
    }
}

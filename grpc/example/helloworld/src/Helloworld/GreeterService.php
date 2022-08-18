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

class GreeterService implements GreeterInterface
{
    /**
     * @throws GRPC\Exception\InvokeException
     */
    public function SayHello(GRPC\ContextInterface $ctx, HelloRequest $request): HelloReply
    {
        $name = $request->getName();
        $out  = new HelloReply();
        $out->setMessage('hello ' . $name);

        return $out;
    }
}

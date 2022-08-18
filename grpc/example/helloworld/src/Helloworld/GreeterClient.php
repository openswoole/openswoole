<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
# source: helloworld.proto

namespace Helloworld;

class GreeterClient extends \OpenSwoole\GRPC\BaseStub
{
    /**
     * @param mixed $metadata
     *
     * @throws \OpenSwooleGRPC\Exception\InvokeException
     */
    public function SayHello(HelloRequest $request, $metadata = []): HelloReply
    {
        return $this->_simpleRequest('/helloworld.Greeter/SayHello',
        $request,
        ['\Helloworld\HelloReply', 'decode'],
        $metadata);
    }
}

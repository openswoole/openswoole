<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
# source: hello.proto

namespace Hello;

class StreamGreeterClient extends \OpenSwoole\GRPC\BaseStub
{
    /**
     * @param mixed $metadata
     *
     * @throws \OpenSwooleGRPC\Exception\InvokeException
     */
    public function Hello(HelloRequest $request, $metadata = []): HelloReply
    {
        return $this->_serverStreamRequest('/hello.StreamGreeter/Hello',
            $request,
            ['\Hello\HelloReply', 'decode'],
            $metadata);
    }

    public function getNext(): object
    {
        return $this->_getData();
    }
}

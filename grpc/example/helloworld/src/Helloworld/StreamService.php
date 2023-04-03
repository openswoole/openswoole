<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace Helloworld;

use Iterator;
use OpenSwoole\GRPC;

class StreamService implements StreamInterface
{
    /**
     * @return iterable<HelloReply>
     * @throws GRPC\Exception\InvokeException
     */
    public function FetchResponse(GRPC\ContextInterface $ctx, HelloRequest $request): iterable
    {
        return $this->createMessagesSource($request->getName());
    }

    /**
     * This method return infinite iterator to generate messages for stream response without using of generators
     *
     * @param string $name
     * @return iterable
     */
    private function createMessagesSource(string $name): iterable
    {
        return new class($name) implements Iterator {
            /** @var string */
            private $name;

            /** @var int */
            private $key = 0;

            public function __construct(string $name)
            {
                $this->name = $name;
            }

            public function current()
            {
                $reply  = new HelloReply();
                $reply->setMessage('hello ' . $this->name . ': ' . time());

                return $reply;
            }

            public function next()
            {
                \Swoole\Coroutine::sleep(1);

                $this->key++;
            }

            public function key()
            {
                return $this->key;
            }

            public function valid()
            {
                return true;
            }

            public function rewind()
            {
                $this->key = 0;
            }
        };
    }
}

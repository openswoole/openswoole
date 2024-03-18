<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace Hello;

use Exception;
use Helloworld\HelloReply;
use OpenSwoole\GRPC;

class StreamGreeterService implements StreamGreeterInterface
{
    /**
     * @return iterable<HelloReply>
     *
     * @throws GRPC\Exception\InvokeException
     */
    public function Hello(GRPC\ContextInterface $ctx, HelloRequest $request): iterable
    {
        $name = $request->getName();

        while ($guestName = $this->getNameFromQueue()) {
            $out = new HelloReply();
            $out->setMessage("{$guestName} says hello to {$name}.");

            yield $out;
        }
    }

    /**
     * This method imitate work with queue.
     * Name is "consumed" from the queue with random delay and new response is streamed to client.
     *
     * @throws Exception
     */
    private function getNameFromQueue(): string
    {
        static $names = ['Sue', 'Betty', 'Jenny'];

        $randomIndex = random_int(0, 2);

        \Swoole\Coroutine::sleep($randomIndex);

        return $names[$randomIndex];
    }
}

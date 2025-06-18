<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
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

        // use mysql pool:
        if ($mysqlPool = $ctx['WORKER_CONTEXT']->getValue('mysql_pool')) {
            $mysqlClient = $mysqlPool->get();
            $mysqlClient->query('SELECT SLEEP(10)')->fetch();
            $mysqlPool->put($mysqlClient);
        }

        return $out;
    }
}

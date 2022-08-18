<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
require __DIR__ . '/vendor/autoload.php';

use Helloworld\HelloRequest;
use OpenSwoole\GRPC\Client;

\Swoole\Coroutine::set(['log_level' => SWOOLE_LOG_ERROR]);
// Co::set(['log_level' => SWOOLE_LOG_DEBUG]);

Co\run(function () {
    // client side stream push
    $conn   = (new Client('127.0.0.1', 9501))->connect();
    $method = '/helloworld.Greeter/SayHello';

    $message = new HelloRequest();
    $message->setName(str_repeat('x', 100) . time());

    while (1) {
        $conn->send($method, $message);
        \co::sleep(1);
    }

    // $conn->send($method, $message, 'proto', true);
});

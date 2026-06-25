<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require __DIR__ . '/vendor/autoload.php';

use Helloworld\HelloRequest;
use OpenSwoole\GRPC\Client;

OpenSwoole\Coroutine::set(['log_level' => OpenSwoole\Constant::LOG_ERROR]);
// Co::set(['log_level' => \OpenSwoole\Constant::LOG_DEBUG]);

co::run(function () {
    // client side stream push
    $conn   = (new Client('127.0.0.1', 9501))->connect();
    $method = '/helloworld.Greeter/SayHello';

    $message = new HelloRequest();
    $message->setName(str_repeat('x', 100) . time());

    while (1) {
        $conn->send($method, $message);
        co::sleep(1);
    }

    // $conn->send($method, $message, 'proto', true);
});

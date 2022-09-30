<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require __DIR__ . '/vendor/autoload.php';

use Helloworld\HelloRequest;
use OpenSwoole\Constant;
use OpenSwoole\GRPC\Client;

\OpenSwoole\Coroutine::set(['log_level' => Constant::LOG_ERROR]);
// Co::set(['log_level' => Constant::LOG_DEBUG]);

co::run(function () {
    $conn    = (new Client('127.0.0.1', 9501))->connect();
    $client  = new Helloworld\GreeterClient($conn);
    $message = new HelloRequest();
    $message->setName(str_repeat('x', 10));
    $out = $client->sayHello($message);
    var_dump($out->serializeToJsonString());
    $conn->close();
    echo "closed\n";
});

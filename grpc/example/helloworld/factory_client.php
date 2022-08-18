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
use OpenSwoole\GRPC\ClientFactory;

\Swoole\Coroutine::set(['log_level' => SWOOLE_LOG_ERROR]);
// Co::set(['log_level' => SWOOLE_LOG_DEBUG]);

Co\run(function () {
    $conn    = ClientFactory::make('127.0.0.1', 9501)->connect();
    $client  = new Helloworld\GreeterClient($conn);
    $message = new HelloRequest();
    $message->setName(str_repeat('x', 10));
    $out = $client->sayHello($message);

    var_dump($out->serializeToJsonString());
    $conn->close();
    echo "closed\n";
});

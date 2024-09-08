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
use OpenSwoole\GRPC\ClientFactory;
use OpenSwoole\GRPC\Constant;

OpenSwoole\Coroutine::set(['log_level' => OpenSwoole\Constant::LOG_ERROR]);
// Co::set(['log_level' => SWOOLE_LOG_DEBUG]);

co::run(function () {
    // server streaming
    $conn    = ClientFactory::make(['host' => '127.0.0.1', 'port' => 9501]);
    $conn    = (new Client('127.0.0.1', 9501, Constant::GRPC_STREAM))->connect();
    $client  = new Helloworld\StreamClient($conn);
    $message = new HelloRequest();
    $message->setName(str_repeat('x', 10));

    $out = $client->FetchResponse($message);
    var_dump($out->serializeToJsonString());

    while (1) {
        $out = $client->getNext();
        var_dump($out->serializeToJsonString());
    }

    $conn->close();
    echo "closed\n";
});

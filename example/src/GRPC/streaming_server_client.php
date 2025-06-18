<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use Hello\HelloRequest;
use Hello\StreamGreeterClient;
use OpenSwoole\Coroutine;
use OpenSwoole\GRPC\Client;
use OpenSwoole\GRPC\Constant;

require_once __DIR__ . '/../../../vendor/autoload.php';

Coroutine::set(['log_level' => \OpenSwoole\Constant::LOG_ERROR]);

co::run(function () {
    // server streaming
    $conn    = (new Client('127.0.0.1', 9501, Constant::GRPC_STREAM))->connect();
    $client  = new StreamGreeterClient($conn);
    $message = new HelloRequest();
    $message->setName('Bruce');

    $out = $client->Hello($message);
    var_dump($out->serializeToJsonString());

    while (1) {
        $out = $client->getNext();
        var_dump($out->serializeToJsonString());
    }
});

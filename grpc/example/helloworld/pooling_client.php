<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require __DIR__ . '/vendor/autoload.php';

use Helloworld\HelloRequest;
use OpenSwoole\GRPC\ClientFactory;
use OpenSwoole\GRPC\ClientPool;

OpenSwoole\Coroutine::set(['log_level' => OpenSwoole\Constant::LOG_ERROR]);
// Co::set(['log_level' => \OpenSwoole\Constant::LOG_DEBUG]);

co::run(function () {
    $connpool = new ClientPool(ClientFactory::class, ['host' => '127.0.0.1', 'port' => 9501], 16);
    $now      = microtime(true);
    $i        = 16;
    $total    = 100_000;

    while ($i-- > 0) {
        $conn = $connpool->get();
        go(function () use ($conn, $connpool, $now, &$total, $i) {
            $client = new Helloworld\GreeterClient($conn);

            $message = new HelloRequest();
            $message->setName(str_repeat('x', 100));

            while (1) {
                $total--;
                $out = $client->sayHello($message);
                if ($total <= 0) {
                    var_dump($out->serializeToJsonString());
                    echo (int) (100_000 / (microtime(true) - $now)) . "\n";
                    break;
                }
            }
            $connpool->put($conn);
            echo "DONE {$i}\n";
        });
    }

    go(function () use ($connpool) {
        // try to close after 1 second
        co::sleep(1);
        $connpool->close();
        echo "CLOSE\n";
    });
});

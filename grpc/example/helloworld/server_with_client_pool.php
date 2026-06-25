<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
ini_set('memory_limit', '-1');

require __DIR__ . '/vendor/autoload.php';

use Helloworld\GreeterService;
use Helloworld\StreamService;
use OpenSwoole\Core\Coroutine\Client\PDOClientFactory;
use OpenSwoole\Core\Coroutine\Client\PDOConfig;
use OpenSwoole\Core\Coroutine\Pool\ClientPool;
use OpenSwoole\GRPC\Middleware\LoggingMiddleware;
use OpenSwoole\GRPC\Middleware\TraceMiddleware;
use OpenSwoole\GRPC\Server;

// enable hooks on IO clients
co::set(['hook_flags' => OpenSwoole\Runtime::HOOK_ALL]);

$server = (new Server('127.0.0.1', 9501))
    ->register(GreeterService::class)
    ->register(StreamService::class)
    ->withWorkerContext('worker_start_time', function () {
        return time();
    })
    // use mysql_pool
    ->withWorkerContext('mysql_pool', function () {
        return new ClientPool(PDOClientFactory::class, new PDOConfig(), 8, true);
    })
    // use middlewares
    // ->addMiddleware(new LoggingMiddleware())
    // ->addMiddleware(new TraceMiddleware())
    ->set([
        'log_level' => OpenSwoole\Constant::LOG_INFO,
    ])
    ->start()
;

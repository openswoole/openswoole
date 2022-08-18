<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
ini_set('memory_limit', '-1');

require __DIR__ . '/vendor/autoload.php';

use Helloworld\GreeterService;
use Helloworld\StreamService;
use OpenSwoole\GRPC\LoggingInterceptor;
use OpenSwoole\GRPC\Server;
use OpenSwoole\GRPC\TraceInterceptor;

$server = (new Server('127.0.0.1', 9501))
    ->register(GreeterService::class)
    ->register(StreamService::class)
    ->withInterceptor(TraceInterceptor::class)
    ->withInterceptor(LoggingInterceptor::class)
    ->withWorkerContext('worker_start_time', function () {
        return time();
    })
    ->set([
        'log_level' => \SWOOLE_LOG_INFO,
    ])
    ->start()
;

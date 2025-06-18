<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use Hello\StreamGreeterService;
use OpenSwoole\Constant;
use OpenSwoole\GRPC\Middleware\LoggingMiddleware;
use OpenSwoole\GRPC\Middleware\TraceMiddleware;
use OpenSwoole\GRPC\Server;

require_once __DIR__ . '/../../../vendor/autoload.php';

// enable hooks on IO clients
co::set(['hook_flags' => OpenSwoole\Runtime::HOOK_ALL]);

$server = (new Server('127.0.0.1', 9501))
    ->register(StreamGreeterService::class)
    ->withWorkerContext('worker_start_time', function () {
        return time();
    })
    // use middlewares
    ->addMiddleware(new LoggingMiddleware())
    ->addMiddleware(new TraceMiddleware())
    ->set([
        'log_level' => Constant::LOG_INFO,
    ])
;

$server->start();

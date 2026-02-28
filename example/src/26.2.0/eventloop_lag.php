<?php
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Timer;

$server = new Server('0.0.0.0', 9501, OPENSWOOLE_BASE);
$server->set([
    'worker_num' => 1,
    'enable_coroutine' => false, // disable so sleep() truly blocks the event loop
]);

$server->on('workerStart', function (Server $server) {
    // Print lag stats every 3 seconds
    Timer::tick(3000, function () use ($server) {
        $stats = $server->stats();
        echo sprintf(
            "lag: %.2fms | max: %.2fms | avg: %.2fms\n",
            $stats['event_loop_lag_ms'],
            $stats['event_loop_lag_max_ms'],
            $stats['event_loop_lag_avg_ms']
        );
    });
});

$server->on('request', function (Request $request, Response $response) use ($server) {
    if ($request->server['request_uri'] === '/block') {
        // Simulate blocking work — this will spike the lag
        usleep(500 * 1000); // 500ms block
        $response->end("Blocked for 500ms\n");
    } elseif ($request->server['request_uri'] === '/stats') {
        $stats = $server->stats();
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode([
            'event_loop_lag_ms' => $stats['event_loop_lag_ms'],
            'event_loop_lag_max_ms' => $stats['event_loop_lag_max_ms'],
            'event_loop_lag_avg_ms' => $stats['event_loop_lag_avg_ms'],
        ], JSON_PRETTY_PRINT) . "\n");
    } else {
        $response->end("GET /block to simulate lag, GET /stats to view lag metrics\n");
    }
});

$server->start();

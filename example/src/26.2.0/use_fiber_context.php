<?php
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Coroutine\Channel;

/**
 * Demonstrates the use_fiber_context option.
 *
 * When enabled, coroutines use PHP's native fiber stack mechanism internally.
 * This enables xdebug step debugging, proper stack overflow protection, and
 * correct VM state isolation inside coroutines.
 *
 * Note: Coroutines do NOT become PHP Fiber objects — Fiber::getCurrent()
 * returns null. Use Co::getCid() to check if you're inside a coroutine.
 *
 * Endpoints:
 *   GET /           — shows usage instructions
 *   GET /coroutine  — shows coroutine info for the current request
 *   GET /concurrent — demonstrates concurrent coroutines with Co::set
 */

Co::set(['use_fiber_context' => true]);

$server = new Server('0.0.0.0', 9501, OPENSWOOLE_BASE);
$server->set(['worker_num' => 2]);

echo "Server starting at http://0.0.0.0:9501 (use_fiber_context enabled)\n";

$server->on('request', function (Request $request, Response $response) {
    $uri = $request->server['request_uri'];

    if ($uri === '/coroutine') {
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode([
            'coroutine_id' => Co::getCid(),
            'coroutine_count' => Co::stats()['coroutine_num'],
            'use_fiber_context' => true,
        ], JSON_PRETTY_PRINT) . "\n");
    } elseif ($uri === '/concurrent') {
        // Spawn two child coroutines that run concurrently
        $channel = new Channel(2);

        go(function () use ($channel) {
            Co::usleep(100000);
            $channel->push(['task' => 'A', 'cid' => Co::getCid()]);
        });

        go(function () use ($channel) {
            Co::usleep(100000);
            $channel->push(['task' => 'B', 'cid' => Co::getCid()]);
        });

        $results = [];
        $results[] = $channel->pop();
        $results[] = $channel->pop();

        $response->header('Content-Type', 'application/json');
        $response->end(json_encode([
            'parent_cid' => Co::getCid(),
            'results' => $results,
        ], JSON_PRETTY_PRINT) . "\n");
    } else {
        $response->end("GET /coroutine to check coroutine context, GET /concurrent to test concurrent coroutines\n");
    }
});

$server->start();

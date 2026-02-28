<?php
use OpenSwoole\Coroutine;
use OpenSwoole\Coroutine\Channel;
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

/**
 * Demonstrates Xdebug step-debugging with use_fiber_context enabled.
 *
 * With use_fiber_context, Xdebug works correctly — breakpoints, step-through,
 * and stack traces behave as expected across coroutine context switches.
 *
 * Prerequisites:
 *   1. Install Xdebug 3.x:  pecl install xdebug
 *   2. php.ini settings:
 *        zend_extension=xdebug
 *        xdebug.mode=debug
 *        xdebug.start_with_request=trigger
 *        xdebug.client_host=127.0.0.1
 *        xdebug.client_port=9003
 *   3. Start your IDE debugger listener (VSCode, PhpStorm, etc.)
 *
 * Usage:
 *   php xdebug_fiber_context.php
 *
 * Or run with Xdebug trace logging:
 *   php -d xdebug.mode=trace \
 *       -d xdebug.start_with_request=yes \
 *       -d xdebug.output_dir=/tmp \
 *       -d xdebug.trace_output_name=openswoole_trace \
 *       -d xdebug.trace_format=0 \
 *       -d xdebug.collect_return=1 \
 *       -d xdebug.use_compression=false \
 *       examples/xdebug_fiber_context.php
 *
 *   tail -f /tmp/openswoole_trace.xt
 *
 * Trigger a debug session:
 *   curl "http://127.0.0.1:9501/debug?XDEBUG_SESSION=1"
 *   curl "http://127.0.0.1:9501/async?XDEBUG_SESSION=1"
 *
 * Endpoints:
 *   GET /         — shows usage instructions and Xdebug status
 *   GET /debug    — hits a simulated breakpoint area with local variables
 *   GET /async    — runs concurrent coroutines, each debuggable independently
 */

Coroutine::set(['use_fiber_context' => true]);

$server = new Server('0.0.0.0', 9501, OPENSWOOLE_BASE);
$server->set(['worker_num' => 1]);

echo "Server starting at http://0.0.0.0:9501 (Xdebug + use_fiber_context)\n";
echo "Trigger debug: curl \"http://127.0.0.1:9501/debug?XDEBUG_SESSION=1\"\n";

$server->on('request', function (Request $request, Response $response) {
    $uri = $request->server['request_uri'];

    if ($uri === '/debug') {
        // Set a breakpoint on any line below in your IDE.
        // With use_fiber_context, Xdebug can pause and inspect each variable.
        $userId = 42;
        $name = 'Alice';
        $items = ['widget', 'gadget', 'gizmo'];

        // Simulate some work — step through this in the debugger
        $total = 0;
        foreach ($items as $index => $item) {
            $total += strlen($item) * ($index + 1); // breakpoint here
        }

        $result = [
            'user_id'      => $userId,
            'name'         => $name,
            'items'        => $items,
            'total'        => $total,
            'coroutine_id' => Coroutine::getCid(),
        ];

        $response->header('Content-Type', 'application/json');
        $response->end(json_encode($result, JSON_PRETTY_PRINT) . "\n");

    } elseif ($uri === '/async') {
        // Run two coroutines concurrently, each debuggable independently.
        $channel = new Channel(2);

        Coroutine::create(function () use ($channel) {
            // Breakpoint here to inspect coroutine A
            Coroutine::sleep(1);
            $channel->push([
                'task'         => 'A',
                'coroutine_id' => Coroutine::getCid(),
            ]);
        });

        Coroutine::create(function () use ($channel) {
            // Breakpoint here to inspect coroutine B
            Coroutine::sleep(1);
            $channel->push([
                'task'         => 'B',
                'coroutine_id' => Coroutine::getCid(),
            ]);
        });

        $results = [];
        $results[] = $channel->pop();
        $results[] = $channel->pop();

        $response->header('Content-Type', 'application/json');
        $response->end(json_encode($results, JSON_PRETTY_PRINT) . "\n");

    } else {
        $xdebugLoaded = extension_loaded('xdebug');
        $lines = [
            'Xdebug + use_fiber_context Example',
            '',
            'Xdebug loaded: ' . ($xdebugLoaded ? 'yes' : 'NO — install xdebug to debug'),
            'use_fiber_context: enabled',
            '',
            'Endpoints:',
            '  GET /debug  — step-debug with local variables',
            '  GET /async  — debug concurrent coroutines',
            '',
            'Add ?XDEBUG_SESSION=1 to trigger a debug session.',
        ];
        $response->end(implode("\n", $lines) . "\n");
    }
});

$server->start();

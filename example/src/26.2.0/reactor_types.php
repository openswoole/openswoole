<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use OpenSwoole\Constant;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Http\Server;

/**
 * Demonstrates the reactor type constants added in ext-openswoole 26.2.0.
 *
 * Available reactor backends:
 *   Constant::REACTOR_SELECT   (0) — portable, uses select()
 *   Constant::REACTOR_POLL     (1) — uses poll()
 *   Constant::REACTOR_EPOLL    (2) — Linux, uses epoll
 *   Constant::REACTOR_KQUEUE   (3) — macOS/BSD, uses kqueue
 *   Constant::REACTOR_IO_URING (4) — Linux 5.1+, uses io_uring
 *
 * Usage:
 *   php reactor_types.php            # auto-detect best backend
 *   php reactor_types.php epoll      # force epoll
 *   php reactor_types.php kqueue     # force kqueue
 */
$reactorMap = [
    'select'   => Constant::REACTOR_SELECT,
    'poll'     => Constant::REACTOR_POLL,
    'epoll'    => Constant::REACTOR_EPOLL,
    'kqueue'   => Constant::REACTOR_KQUEUE,
    'io_uring' => Constant::REACTOR_IO_URING,
];

$chosen = $argv[1] ?? null;

if ($chosen !== null && !isset($reactorMap[$chosen])) {
    echo "Unknown reactor type: {$chosen}\n";
    echo 'Available: ' . implode(', ', array_keys($reactorMap)) . "\n";
    exit(1);
}

$server = new Server('0.0.0.0', 9501, OPENSWOOLE_BASE);

$settings = ['worker_num' => 2];
if ($chosen !== null) {
    $settings['reactor_type'] = $reactorMap[$chosen];
    echo "Reactor type forced to: {$chosen} ({$reactorMap[$chosen]})\n";
} else {
    echo "Reactor type: auto-detect (default)\n";
}
$server->set($settings);

$server->on('request', function (Request $request, Response $response) use ($chosen) {
    $response->header('Content-Type', 'application/json');
    $response->end(json_encode([
        'reactor_type' => $chosen ?? 'auto',
        'constants'    => [
            'REACTOR_SELECT'   => Constant::REACTOR_SELECT,
            'REACTOR_POLL'     => Constant::REACTOR_POLL,
            'REACTOR_EPOLL'    => Constant::REACTOR_EPOLL,
            'REACTOR_KQUEUE'   => Constant::REACTOR_KQUEUE,
            'REACTOR_IO_URING' => Constant::REACTOR_IO_URING,
        ],
    ], JSON_PRETTY_PRINT) . "\n");
});

echo "Server starting at http://0.0.0.0:9501\n";
$server->start();

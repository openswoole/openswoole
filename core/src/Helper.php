<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core;

use OpenSwoole\Http\Server;
use Psr\Http\Server\RequestHandlerInterface;

class Helper
{
    public static function handle(Server $server, callable $callback)
    {
        $server->on('request', function (\OpenSwoole\HTTP\Request $request, \OpenSwoole\HTTP\Response $response) use ($callback) {
            $serverRequest  = Psr\ServerRequest::from($request);
            $serverResponse = $callback($serverRequest);
            Psr\Response::emit($response, $serverResponse);
        });
    }

    public static function setHandler(Server $server, RequestHandlerInterface $handler)
    {
        $server->on('request', function (\OpenSwoole\HTTP\Request $request, \OpenSwoole\HTTP\Response $response) use ($handler) {
            $serverRequest  = Psr\ServerRequest::from($request);
            $serverResponse = $handler->handle($serverRequest);
            Psr\Response::emit($response, $serverResponse);
        });
    }

    public static function statsToOpenMetrics(array $stats)
    {
        $event_workers = '';
        $event_workers .= "# TYPE openswoole_event_workers_start_time gauge\n";
        foreach ($stats['event_workers'] as $stat) {
            $event_workers .= "openswoole_event_workers_start_time{worker_id=\"{$stat['worker_id']}\"} {$stat['start_time']}\n";
        }
        $event_workers .= "# TYPE openswoole_event_workers_start_seconds gauge\n";
        foreach ($stats['event_workers'] as $stat) {
            $event_workers .= "openswoole_event_workers_start_seconds{worker_id=\"{$stat['worker_id']}\"} {$stat['start_seconds']}\n";
        }
        $event_workers .= "# TYPE openswoole_event_workers_dispatch_count gauge\n";
        foreach ($stats['event_workers'] as $stat) {
            $event_workers .= "openswoole_event_workers_dispatch_count{worker_id=\"{$stat['worker_id']}\"} {$stat['dispatch_count']}\n";
        }
        $event_workers .= "# TYPE openswoole_event_workers_request_count gauge\n";
        foreach ($stats['event_workers'] as $stat) {
            $event_workers .= "openswoole_event_workers_request_count{worker_id=\"{$stat['worker_id']}\"} {$stat['request_count']}\n";
        }

        $task_workers = '';
        $task_workers .= "# TYPE openswoole_task_workers_start_time gauge\n";
        foreach ($stats['task_workers'] as $stat) {
            $task_workers .= "openswoole_task_workers_start_time{worker_id=\"{$stat['worker_id']}\"} {$stat['start_time']}\n";
        }
        $task_workers .= "# TYPE openswoole_task_workers_start_seconds gauge\n";
        foreach ($stats['task_workers'] as $stat) {
            $task_workers .= "openswoole_task_workers_start_seconds{worker_id=\"{$stat['worker_id']}\"} {$stat['start_seconds']}\n";
        }

        $user_workers = '';
        $user_workers .= "# TYPE openswoole_user_workers_start_time gauge\n";
        foreach ($stats['user_workers'] as $stat) {
            $user_workers .= "openswoole_user_workers_start_time{worker_id=\"{$stat['worker_id']}\"} {$stat['start_time']}\n";
        }
        $user_workers .= "# TYPE openswoole_user_workers_start_seconds gauge\n";
        foreach ($stats['user_workers'] as $stat) {
            $user_workers .= "openswoole_user_workers_start_seconds{worker_id=\"{$stat['worker_id']}\"} {$stat['start_seconds']}\n";
        }

        return "# TYPE openswoole_info gauge\n"
                . "openswoole_info{version=\"{$stats['version']}\"} 1\n"
                . "# TYPE openswoole_up gauge\n"
                . "openswoole_up {$stats['up']}\n"
                . "# TYPE openswoole_reactor_num gauge\n"
                . "openswoole_reactor_threads_num {$stats['reactor_threads_num']}\n"
                . "# TYPE openswoole_requests counter\n"
                . "openswoole_requests_total {$stats['requests_total']}\n"
                . "# TYPE openswoole_start_time gauge\n"
                . "openswoole_start_time {$stats['start_time']}\n"
                . "# TYPE openswoole_max_conn gauge\n"
                . "openswoole_max_conn {$stats['max_conn']}\n"
                . "# TYPE openswoole_coroutine_num gauge\n"
                . "openswoole_coroutine_num {$stats['coroutine_num']}\n"
                . "# TYPE openswoole_start_seconds gauge\n"
                . "openswoole_start_seconds {$stats['start_seconds']}\n"
                . "# TYPE openswoole_workers_total gauge\n"
                . "openswoole_workers_total {$stats['workers_total']}\n"
                . "# TYPE openswoole_workers_idle gauge\n"
                . "openswoole_workers_idle {$stats['workers_idle']}\n"
                . "# TYPE openswoole_task_workers_total gauge\n"
                . "openswoole_task_workers_total {$stats['task_workers_total']}\n"
                . "# TYPE openswoole_task_workers_idle gauge\n"
                . "openswoole_task_workers_idle {$stats['task_workers_idle']}\n"
                . "# TYPE openswoole_user_workers_total gauge\n"
                . "openswoole_user_workers_total {$stats['user_workers_total']}\n"
                . "# TYPE openswoole_dispatch_total gauge\n"
                . "openswoole_dispatch_total {$stats['dispatch_total']}\n"
                . "# TYPE openswoole_connections_accepted gauge\n"
                . "openswoole_connections_accepted {$stats['connections_accepted']}\n"
                . "# TYPE openswoole_connections_active gauge\n"
                . "openswoole_connections_active {$stats['connections_active']}\n"
                . "# TYPE openswoole_connections_closed gauge\n"
                . "openswoole_connections_closed {$stats['connections_closed']}\n"
                . "# TYPE openswoole_reload_count gauge\n"
                . "openswoole_reload_count {$stats['reload_count']}\n"
                . "# TYPE openswoole_reload_last_time gauge\n"
                . "openswoole_reload_last_time {$stats['reload_last_time']}\n"
                . "# TYPE openswoole_worker_vm_object_num gauge\n"
                . "openswoole_worker_vm_object_num {$stats['worker_vm_object_num']}\n"
                . "# TYPE openswoole_worker_vm_resource_num gauge\n"
                . "openswoole_worker_vm_resource_num {$stats['worker_vm_resource_num']}\n"
                . "# TYPE openswoole_worker_memory_usage gauge\n"
                . "openswoole_worker_memory_usage {$stats['worker_memory_usage']}\n{$event_workers}{$task_workers}{$user_workers}"
                . '# EOF';
    }
}

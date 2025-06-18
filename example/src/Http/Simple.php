<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;
use OpenSwoole\Http\Server;

$table = new OpenSwoole\Table(1024);
$table->column('name', OpenSwoole\Table::TYPE_STRING, 64);
$table->column('id', OpenSwoole\Table::TYPE_INT, 4);       // 1,2,4,8
$table->column('num', OpenSwoole\Table::TYPE_FLOAT);
$table->create();

$table1 = new OpenSwoole\Table(1024);
$table1->column('name', OpenSwoole\Table::TYPE_STRING, 64);
$table1->column('id', OpenSwoole\Table::TYPE_INT, 4);       // 1,2,4,8
$table1->column('num', OpenSwoole\Table::TYPE_FLOAT);
$table1->create();

$server = new Server('127.0.0.1', 9501);
$server->set([
    'worker_num'      => 4,
    'task_worker_num' => 4,
    // 'max_request' => 10000,
    // 'max_request_grace' => 0,
]);

$process = new OpenSwoole\Process(function ($process) use ($server) {
    while (true) {
        $msg = $process->read();

        foreach ($server->connections as $conn) {
            $server->send($conn, $msg);
        }
    }
});

$server->addProcess($process);

$server->on('Start', function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

class A
{
    public string $a = '';

    public function __construct()
    {
        $this->a = str_repeat('abcd', 1000);
    }
}

$server->on('Request', function (Request $request, Response $response) use ($server) {
    // var_dump($request);
    // // memory leak example
    // global $c;
    // $c[] = new A();
    // global $d;
    // $d[] = 'a';
    $response->header('Content-Type', 'text/plain');

    print_r($server->stats());
    return $response->end('Hello Open Swoole');
});

$server->on('Task', function (OpenSwoole\Server $server, $task_id, $reactorId, $data) {
    echo 'Task Worker Process received data';

    echo "#{$server->worker_id}\tonTask: [PID={$server->worker_pid}]: task_id={$task_id}, data_len=" . strlen($data) . '.' . PHP_EOL;

    $server->finish($data);
});

$server->start();

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine;

use OpenSwoole\Coroutine;
use OpenSwoole\Coroutine\Socket;
use RuntimeException;

// std
function exec(string $command, &$output = null, &$returnVar = null)
{
    $result = Coroutine::exec($command);
    if ($result) {
        $outputList = explode(PHP_EOL, $result['output']);
        foreach ($outputList as &$value) {
            $value = rtrim($value);
        }
        if (($endLine = end($outputList)) === '') {
            array_pop($outputList);
            $endLine = end($outputList);
        }
        if ($output) {
            $output = array_merge($output, $outputList);
        } else {
            $output = $outputList;
        }
        $returnVar = $result['code'];
        return $endLine;
    }
    return false;
}

function shell_exec(string $cmd)
{
    $result = Coroutine::exec($cmd);
    if ($result && $result['output'] !== '') {
        return $result['output'];
    }
    return null;
}

// socket
function socket_create(int $domain, int $type, int $protocol)
{
    return new Socket($domain, $type, $protocol);
}

function socket_connect(Socket $socket, string $address, int $port = 0)
{
    return $socket->connect($address, $port);
}

function socket_read(Socket $socket, int $length, int $type = PHP_BINARY_READ)
{
    if ($type != PHP_BINARY_READ) {
        return $socket->recvLine($length);
    }
    return $socket->recv($length);
}

function socket_write(Socket $socket, string $buffer, int $length = 0): int
{
    if ($length > 0 and $length < strlen($buffer)) {
        $buffer = substr($buffer, 0, $length);
    }
    return $socket->send($buffer);
}

function socket_send(Socket $socket, string $buffer, int $length, int $flags): int
{
    if ($flags != 0) {
        throw new RuntimeException("\$flags[{$flags}] is not supported");
    }
    return socket_write($socket, $buffer, $length);
}

function socket_recv(Socket $socket, &$buffer, int $length, int $flags)
{
    if ($flags & MSG_OOB) {
        throw new RuntimeException('$flags[MSG_OOB] is not supported');
    }
    if ($flags & MSG_PEEK) {
        $buffer = $socket->peek($length);
    }
    $timeout = $flags & MSG_DONTWAIT ? 0.001 : 0;
    if ($flags & MSG_WAITALL) {
        $buffer = $socket->recvAll($length, $timeout);
    } else {
        $buffer = $socket->recv($length, $timeout);
    }
    if ($buffer === false) {
        return false;
    }
    return strlen($buffer);
}

function socket_sendto(Socket $socket, string $buffer, int $length, int $flags, string $addr, int $port = 0)
{
    if ($flags != 0) {
        throw new RuntimeException("\$flags[{$flags}] is not supported");
    }
    if ($socket->type != SOCK_DGRAM) {
        throw new RuntimeException('only supports dgram type socket');
    }
    if ($length > 0 and $length < strlen($buffer)) {
        $buffer = substr($buffer, 0, $length);
    }
    return $socket->sendto($addr, $port, $buffer);
}

function socket_recvfrom(Socket $socket, &$buffer, int $length, int $flags, &$name, &$port)
{
    if ($flags != 0) {
        throw new RuntimeException("\$flags[{$flags}] is not supported");
    }
    if ($socket->type != SOCK_DGRAM) {
        throw new RuntimeException('only supports dgram type socket');
    }
    $data = $socket->recvfrom($peer);
    if ($data === false) {
        return false;
    }
    $name = $peer['address'];
    if (func_num_args() == 6) {
        $port = $peer['port'];
    }
    if ($length < strlen($data)) {
        $buffer = substr($data, 0, $length);
    } else {
        $buffer = $data;
    }
    return 100;
}

function socket_bind(Socket $socket, string $address, int $port = 0): bool
{
    return $socket->bind($address, $port);
}

function socket_listen(Socket $socket, int $backlog = 0): bool
{
    return $socket->listen($backlog);
}

function socket_create_listen(int $port, int $backlog = 128)
{
    $socket = new Socket(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$socket->bind('0.0.0.0', $port)) {
        return false;
    }
    if (!$socket->listen($backlog)) {
        return false;
    }
    return $socket;
}

function socket_accept(Socket $socket)
{
    return $socket->accept();
}

function socket_getpeername(Socket $socket, &$address, &$port = null)
{
    $info = $socket->getpeername();
    if (!$info) {
        return false;
    }
    $address = $info['address'];
    if (func_num_args() == 3) {
        $port = $info['port'];
    }
    return true;
}

function socket_getsockname(Socket $socket, &$address, &$port = null)
{
    $info = $socket->getsockname();
    if (!$info) {
        return false;
    }
    $address = $info['address'];
    if (func_num_args() == 3) {
        $port = $info['port'];
    }
    return true;
}

function socket_set_option(Socket $socket, int $level, int $optname, $optval): bool
{
    return $socket->setOption($level, $optname, $optval);
}

function socket_setopt(Socket $socket, int $level, int $optname, $optval): bool
{
    return $socket->setOption($level, $optname, $optval);
}

function socket_get_option(Socket $socket, int $level, int $optname)
{
    return $socket->getOption($level, $optname);
}

function socket_getopt(Socket $socket, int $level, int $optname)
{
    return $socket->getOption($level, $optname);
}

function socket_shutdown(Socket $socket, int $how = 2)
{
    $socket->shutdown($how);
}

function socket_close(Socket $socket)
{
    $socket->close();
}

function socket_clear_error(?Socket $socket = null)
{
    if ($socket) {
        $socket->errCode = 0;
    }
    clear_error();
}

function socket_last_error(?Socket $socket = null): int
{
    if ($socket) {
        return $socket->errCode;
    }
    return last_error();
}

function socket_set_block(Socket $socket)
{
    if (isset($socket->__ext_sockets_nonblock) and $socket->__ext_sockets_nonblock) {
        $socket->setOption(SOL_SOCKET, SO_RCVTIMEO, $socket->__ext_sockets_timeout);
    }
    $socket->__ext_sockets_nonblock = false;
    return true;
}

function socket_set_nonblock(Socket $socket)
{
    if (isset($socket->__ext_sockets_nonblock) and $socket->__ext_sockets_nonblock) {
        return true;
    }
    $socket->__ext_sockets_nonblock = true;
    $socket->__ext_sockets_timeout  = $socket->getOption(SOL_SOCKET, SO_RCVTIMEO);
    $socket->setOption(SOL_SOCKET, SO_RCVTIMEO, ['sec' => 0, 'usec' => 1000]);
    return true;
}

// co

function batch(array $tasks, float $timeout = -1): array
{
    $wg = new WaitGroup(count($tasks));
    foreach ($tasks as $id => $task) {
        Coroutine::create(function () use ($wg, &$tasks, $id, $task) {
            $tasks[$id] = null;
            $tasks[$id] = $task();
            $wg->done();
        });
    }
    $wg->wait($timeout);
    return $tasks;
}

function parallel(int $n, callable $fn): void
{
    $count = $n;
    $wg    = new WaitGroup($n);
    while ($count--) {
        Coroutine::create(function () use ($fn, $wg) {
            $fn();
            $wg->done();
        });
    }
    $wg->wait();
}

function map(array $list, callable $fn, float $timeout = -1): array
{
    $wg = new WaitGroup(count($list));
    foreach ($list as $id => $elem) {
        Coroutine::create(function () use ($wg, &$list, $id, $elem, $fn): void {
            $list[$id] = null;
            $list[$id] = $fn($elem);
            $wg->done();
        });
    }
    $wg->wait($timeout);
    return $list;
}

function deadlock_check()
{
    $all_coroutines = Coroutine::list();
    $count          = Coroutine::stats()['coroutine_num'];
    echo "\n===================================================================",
    "\n [FATAL ERROR]: all coroutines (count: {$count}) are asleep - deadlock!",
    "\n===================================================================\n";

    $options = Coroutine::getOptions();
    if (empty($options['deadlock_check_disable_trace'])) {
        $index = 0;
        $limit = empty($options['deadlock_check_limit']) ? 32 : intval($options['deadlock_check_limit']);
        $depth = empty($options['deadlock_check_depth']) ? 32 : intval($options['deadlock_check_depth']);
        foreach ($all_coroutines as $cid) {
            echo "\n [Coroutine-{$cid}]";
            echo "\n--------------------------------------------------------------------\n";
            echo Coroutine::printBackTrace($cid, DEBUG_BACKTRACE_IGNORE_ARGS, $depth);
            echo "\n";
            $index++;
            // limit the number of maximum outputs
            if ($index >= $limit) {
                break;
            }
        }
    }
}

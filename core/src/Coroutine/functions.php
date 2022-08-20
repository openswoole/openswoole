<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Core\Coroutine;

use OpenSwoole\Coroutine;

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
    $all_coroutines = Coroutine::listCoroutines();
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

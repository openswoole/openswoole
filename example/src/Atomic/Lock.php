<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

$lock = new OpenSwoole\Atomic(0);

if (pcntl_fork() > 0) {
    echo "master start\n";
    $lock->wait(1.5);
    echo "master end\n";
} else {
    echo "child start\n";
    sleep(1);
    $lock->wakeup();
    echo "child end\n";
}

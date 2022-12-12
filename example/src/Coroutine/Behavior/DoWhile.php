<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
co::set([
    'max_death_ms'         => 2000,
    'death_loop_threshold' => 5,
]);

echo 'start', PHP_EOL;

go(function () {
    echo 'coro start', PHP_EOL;

    while (true) {
        echo '111', PHP_EOL;
        sleep(1);
    }
});

go(function () {
    echo '222222', PHP_EOL;
});

echo 'end', PHP_EOL;

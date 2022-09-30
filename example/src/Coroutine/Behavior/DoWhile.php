<?php

co::set([
    'max_death_ms' => 2000,
    'death_loop_threshold' => 5,
]);

echo 'start', PHP_EOL;

go(function () {
    echo 'coro start', PHP_EOL;

    do {
        echo '111', PHP_EOL;
        sleep(1);
    } while (true);
});

go(function () {
   echo '222222', PHP_EOL;
});

echo 'end', PHP_EOL;

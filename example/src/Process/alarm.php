<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
OpenSwoole\Process::signal(SIGALRM, function () {
    static $i = 0;
    echo "#{$i}\talarm\n";
    $i++;
    if ($i > 20) {
        OpenSwoole\Process::alarm(-1);
    }
});

OpenSwoole\Process::alarm(100 * 1000);

OpenSwoole\Event::wait();

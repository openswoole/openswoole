<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
OpenSwoole\Timer::tick(2000, function ($id) {
    var_dump($id);
});

OpenSwoole\Event::cycle(function () {
    echo "hello [1]\n";
    OpenSwoole\Event::cycle(function () {
        echo "hello [2]\n";
        OpenSwoole\Event::cycle(null);
    });
});

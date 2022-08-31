<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSwoole\Core\Coroutine\WaitGroup;

co::run(function () {
    $wg = new WaitGroup();

    for ($i=0; $i < 10; $i++) {
        $wg->add();
        go(function () use ($wg, $i) {
            co::sleep(1);
            echo "hello {$i}\n";
            $wg->done();
        });
    }

    $wg->wait();
    echo "all done\n";
});

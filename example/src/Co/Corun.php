<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

co::run(function () {
    co::sleep(3);
    echo "Hello corun\n";
});

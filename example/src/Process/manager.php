<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

$manager      = new OpenSwoole\Core\Process\Manager();

$manager->add(function () {
    echo 1;
    co::sleep(2);
}, true);

$manager->add(function () {
    echo 2;
    co::sleep(1);
}, true);

$manager->start();

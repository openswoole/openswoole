<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

$long = new OpenSwoole\Atomic\Long(-2 ** 36);
echo $long->get() . "\n";
echo $long->add(20) . "\n";
echo $long->sub(20) . "\n";
echo $long->sub(-20) . "\n";
echo $long->cmpset(-2 ** 36, 0) . "\n";
echo $long->cmpset(-2 ** 36 + 20, 0) . "\n";

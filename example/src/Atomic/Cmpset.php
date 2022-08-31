<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

$number = new OpenSwoole\Atomic(123);
echo $number->add(12) . "\n";
echo $number->sub(11) . "\n";
echo $number->cmpset(122, 999) . "\n";
echo $number->cmpset(124, 999) . "\n";
echo $number->get() . "\n";

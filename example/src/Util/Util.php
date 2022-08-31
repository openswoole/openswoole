<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

echo OpenSwoole\Util::getVersion() . "\n";
echo OpenSwoole\Util::getCPUNum() . "\n";
var_dump(OpenSwoole\Util::getLocalIp()) . "\n";
var_dump(OpenSwoole\Util::getLocalMac()) . "\n";
echo OpenSwoole\Util::log(1, 'LOG MESSAGE') . "\n";

<?php
/**
 * This file is part of Open Swoole.
 *
 * @see     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use OpenSwoole\Coroutine;

Coroutine::set([
    'log_level'   => SWOOLE_LOG_INFO,
    'trace_flags' => 0,
]);

require __DIR__ . '/../vendor/autoload.php';

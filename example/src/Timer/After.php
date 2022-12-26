<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
function run($timerid, $param)
{
    var_dump($timerid);
    var_dump($param);
}

// Every 1s, execute the run function
OpenSwoole\Timer::tick(1000, 'run', ['param1', 'param2']);

// After 5s execute the run function, only once
OpenSwoole\Timer::after(5000, 'run', ['param3', 'param4']);

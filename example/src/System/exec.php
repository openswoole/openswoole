<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

Co::run(function () {
	var_dump(co::exec("ls -l ."));
});
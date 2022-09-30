<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\Server;

class TaskResult
{
    public $task_id;

    public $task_worker_id;

    public $dispatch_time;

    public $data;
}

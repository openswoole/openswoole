<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Server;

class TaskResult
{
    public $task_id;

    public $task_worker_id;

    public $dispatch_time;

    public $data;
}

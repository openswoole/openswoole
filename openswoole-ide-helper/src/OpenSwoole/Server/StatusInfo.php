<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Server;

class StatusInfo
{
    public $worker_id;

    public $worker_pid;

    public $status;

    public $exit_code;

    public $signal;
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Server;

class Event
{
    public $reactor_id;

    public $fd;

    public $dispatch_time;

    public $data;
}

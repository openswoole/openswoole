<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\Server;

final class Task
{
    public $data;

    public $dispatch_time;

    public $id;

    public $worker_id;

    public $flags;

    /**
     * @param mixed $data [required]
     */
    public function finish($data): bool
    {
    }

    /**
     * @param mixed $data [required]
     * @return bool|string
     */
    public static function pack($data)
    {
    }
}

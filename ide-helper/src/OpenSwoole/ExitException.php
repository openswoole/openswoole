<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole;

class ExitException extends Exception
{
    private $flags;

    private $status;

    public function getFlags()
    {
    }

    public function getStatus()
    {
    }
}

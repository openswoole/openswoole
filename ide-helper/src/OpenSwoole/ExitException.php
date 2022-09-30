<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole;

class ExitException extends \OpenSwoole\Exception
{
    private $flags;

    private $status;

    /**
     * @return mixed
     */
    public function getFlags()
    {
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\WebSocket;

class CloseFrame extends \OpenSwoole\WebSocket\Frame
{
    public int $code;

    public ?string $reason;
}

<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\WebSocket;

class CloseFrame extends \OpenSwoole\WebSocket\Frame
{
    public int $code;

    public ?string $reason;
}

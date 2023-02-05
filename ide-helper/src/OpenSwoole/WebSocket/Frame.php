<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\WebSocket;

use Stringable;

class Frame implements Stringable
{
    public int $fd;

    public ?string $data;

    public int $opcode;

    public int $flags;

    public bool $finish;

    public function __toString(): string
    {
    }

    /**
     * @param \OpenSwoole\WebSocket\Frame|string $data
     */
    public static function pack($data, int $opcode = Server::WEBSOCKET_OPCODE_TEXT, int $flags = Server::WEBSOCKET_FLAG_FIN): string
    {
    }

    /**
     * @return \OpenSwoole\WebSocket\Frame|false
     */
    public static function unpack(string $data)
    {
    }
}

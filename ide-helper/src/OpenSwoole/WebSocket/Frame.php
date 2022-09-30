<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\WebSocket;

class Frame implements \Stringable
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
     * @param \Swoole\WebSocket\Frame|string $data
     * @param int $opcode
     * @param int $flags
     * @return string
     */
    public static function pack($data, int $opcode = Server::WEBSOCKET_OPCODE_TEXT, int $flags = Server::WEBSOCKET_FLAG_FIN): string
    {
    }

    /**
     * @param string $data
     * @return \Swoole\WebSocket\Frame|false
     */
    public static function unpack(string $data)
    {
    }
}

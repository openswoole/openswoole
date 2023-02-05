<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\WebSocket;

class Server extends \OpenSwoole\Http\Server
{
    public const WEBSOCKET_STATUS_CONNECTION = 1;

    public const WEBSOCKET_STATUS_HANDSHAKE = 2;

    public const WEBSOCKET_STATUS_ACTIVE = 3;

    public const WEBSOCKET_STATUS_CLOSING = 4;

    public const WEBSOCKET_OPCODE_CONTINUATION = 0;

    public const WEBSOCKET_OPCODE_TEXT = 1;

    public const WEBSOCKET_OPCODE_BINARY = 2;

    public const WEBSOCKET_OPCODE_CLOSE = 8;

    public const WEBSOCKET_OPCODE_PING = 9;

    public const WEBSOCKET_OPCODE_PONG = 10;

    public const WEBSOCKET_FLAG_FIN = 1;

    public const WEBSOCKET_FLAG_RSV1 = 4;

    public const WEBSOCKET_FLAG_RSV2 = 8;

    public const WEBSOCKET_FLAG_RSV3 = 16;

    public const WEBSOCKET_FLAG_MASK = 32;

    public const WEBSOCKET_FLAG_COMPRESS = 2;

    public const WEBSOCKET_CLOSE_NORMAL = 1000;

    public const WEBSOCKET_CLOSE_GOING_AWAY = 1001;

    public const WEBSOCKET_CLOSE_PROTOCOL_ERROR = 1002;

    public const WEBSOCKET_CLOSE_DATA_ERROR = 1003;

    public const WEBSOCKET_CLOSE_STATUS_ERROR = 1005;

    public const WEBSOCKET_CLOSE_ABNORMAL = 1006;

    public const WEBSOCKET_CLOSE_MESSAGE_ERROR = 1007;

    public const WEBSOCKET_CLOSE_POLICY_ERROR = 1008;

    public const WEBSOCKET_CLOSE_MESSAGE_TOO_BIG = 1009;

    public const WEBSOCKET_CLOSE_EXTENSION_MISSING = 1010;

    public const WEBSOCKET_CLOSE_SERVER_ERROR = 1011;

    public const WEBSOCKET_CLOSE_TLS = 1015;

    /**
     * @param \OpenSwoole\WebSocket\Frame|string $data
     */
    public function push(int $fd, $data, int $opcode = Server::WEBSOCKET_OPCODE_TEXT, int $flags = Server::WEBSOCKET_FLAG_FIN): bool
    {
    }

    public function disconnect(int $fd, int $code = Server::WEBSOCKET_CLOSE_NORMAL, string $reason = ''): bool
    {
    }

    public function isEstablished(int $fd): bool
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

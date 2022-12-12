<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine\Http2;

use OpenSwoole\Http2\Request;
use OpenSwoole\Http2\Response;

class Client
{
    public const HTTP2_TYPE_DATA = 0;

    public const HTTP2_TYPE_HEADERS = 1;

    public const HTTP2_TYPE_PRIORITY = 2;

    public const HTTP2_TYPE_RST_STREAM = 3;

    public const HTTP2_TYPE_SETTINGS = 4;

    public const HTTP2_TYPE_PUSH_PROMISE = 5;

    public const HTTP2_TYPE_PING = 6;

    public const HTTP2_TYPE_GOAWAY = 7;

    public const HTTP2_TYPE_WINDOW_UPDATE = 8;

    public const HTTP2_TYPE_CONTINUATION = 9;

    public const HTTP2_ERROR_NO_ERROR = 0;

    public const HTTP2_ERROR_PROTOCOL_ERROR = 1;

    public const HTTP2_ERROR_INTERNAL_ERROR = 2;

    public const HTTP2_ERROR_FLOW_CONTROL_ERROR = 3;

    public const HTTP2_ERROR_SETTINGS_TIMEOUT = 4;

    public const HTTP2_ERROR_STREAM_CLOSED = 5;

    public const HTTP2_ERROR_FRAME_SIZE_ERROR = 6;

    public const HTTP2_ERROR_REFUSED_STREAM = 7;

    public const HTTP2_ERROR_CANCEL = 8;

    public const HTTP2_ERROR_COMPRESSION_ERROR = 9;

    public const HTTP2_ERROR_CONNECT_ERROR = 10;

    public const HTTP2_ERROR_ENHANCE_YOUR_CALM = 11;

    public const HTTP2_ERROR_INADEQUATE_SECURITY = 12;

    public int $errCode = 0;

    /**
     * @var int|string
     */
    public $errMsg = 0;

    public int $sock = -1;

    public int $type = 0;

    public ?array $setting;

    public bool $connected = false;

    public string $host;

    public int $port = 0;

    public bool $ssl = false;

    public function __construct(string $host, int $port = 80, bool $openSSL = false)
    {
    }

    public function __destruct()
    {
    }

    public function set(array $options): void
    {
    }

    public function connect(): bool
    {
    }

    /**
     * @return array|bool|int
     */
    public function stats(string $key = null)
    {
    }

    public function isStreamExist(int $stream_id): bool
    {
    }

    /**
     * @return int|bool
     */
    public function send(Request $request)
    {
    }

    /**
     * @param mixed $data
     */
    public function write(int $streamId, $data, bool $end = false): bool
    {
    }

    /**
     * @return Response|false
     */
    public function recv(?float $timeout = 0)
    {
    }

    /**
     * @return Response|false
     */
    public function read(?float $timeout = 0)
    {
    }

    public function goaway(int $errorCode = Client::HTTP2_ERROR_NO_ERROR, string $debugData): bool
    {
    }

    public function ping(): bool
    {
    }

    public function close(): bool
    {
    }
}

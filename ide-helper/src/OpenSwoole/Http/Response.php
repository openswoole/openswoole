<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Http;

final class Response
{
    public int $fd;

    public $socket;

    public ?array $header;

    public ?array $cookie;

    public $trailer;

    public function __destruct()
    {
    }

    public function write(string $data): bool
    {
    }

    public function end(?string $data = null): bool
    {
    }

    public function sendfile(string $fileName, int $offset = 0, int $length = 0): bool
    {
    }

    public function redirect(string $url, int $status_code = 302): ?bool
    {
    }

    public function cookie(string $key, ?string $value = null, int $expire = 0, string $path = '', string $domain = '', bool $secure = false, bool $httpOnly = false, string $sameSite = '', string $priority = ''): bool
    {
    }

    public function rawcookie(string $key, ?string $value = null, int $expire = 0, string $path = '', string $domain = '', bool $secure = false, bool $httpOnly = false, string $sameSite = '', string $priority = ''): bool
    {
    }

    public function header(string $key, string $value, bool $format = true): bool
    {
    }

    public function initHeader(): bool
    {
    }

    public function isWritable(): bool
    {
    }

    public function detach(): bool
    {
    }

    /**
     * @param mixed $server
     * @return Response|bool
     */
    public static function create($server = -1, int $fd = -1)
    {
    }

    public function upgrade(): bool
    {
    }

    /**
     * @param \OpenSwoole\WebSocket\Frame|string $data
     */
    public function push($data, int $opcode = \OpenSwoole\WebSocket\Server::WEBSOCKET_OPCODE_TEXT, int $flags = \OpenSwoole\WebSocket\Server::WEBSOCKET_FLAG_FIN): bool
    {
    }

    /**
     * @return \OpenSwoole\WebSocket\Frame|bool|string
     */
    public function recv(float $timeout = 0)
    {
    }

    public function close(): bool
    {
    }

    public function trailer(string $key, string $value): bool
    {
    }

    public function ping(): bool
    {
    }

    public function goaway(int $errorCode = \OpenSwoole\Coroutine\Http2\Client::HTTP2_ERROR_NO_ERROR, string $debugData = ''): bool
    {
    }

    public function status(int $statusCode, string $reason = ''): bool
    {
    }
}

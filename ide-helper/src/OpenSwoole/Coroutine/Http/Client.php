<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine\Http;

use OpenSwoole\WebSocket\Frame;

final class Client
{
    public const HTTP_CLIENT_ESTATUS_CONNECT_FAILED = -1;

    public const HTTP_CLIENT_ESTATUS_REQUEST_TIMEOUT = -2;

    public const HTTP_CLIENT_ESTATUS_SERVER_RESET = -3;

    public const HTTP_CLIENT_ESTATUS_SEND_FAILED = -4;

    public int $errCode;

    public string $errMsg;

    public bool $connected;

    public string $host;

    public int $port;

    public bool $ssl;

    public ?array $setting;

    public ?string $requestMethod;

    public ?array $requestHeaders;

    /**
     * @var string|array|null
     */
    public $requestBody;

    /**
     * @var mixed
     */
    public $uploadFiles;

    /**
     * @var mixed
     */
    public $downloadFile;

    public int $downloadOffset;

    public int $statusCode;

    public $headers;

    /**
     * @var mixed
     */
    public $set_cookie_headers;

    public $cookies;

    public ?string $body;

    /**
     * @param string $host [required]
     * @param int $port [optional]
     * @param bool $ssl [optional]
     */
    public function __construct(string $host, int $port, bool $ssl = false)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param array $settings [required]
     */
    public function set(array $settings): bool
    {
    }

    public function getDefer(): bool
    {
    }

    /**
     * @param bool $defer [optional]
     */
    public function setDefer(bool $defer = true): void
    {
    }

    /**
     * @param mixed $method [required]
     */
    public function setMethod(string $method): void
    {
    }

    /**
     * @param array $headers [required]
     */
    public function setHeaders(array $headers): void
    {
    }

    /**
     * @param mixed $username [required]
     * @param mixed $password [required]
     */
    public function setBasicAuth(string $username, string $password): void
    {
    }

    /**
     * @param array $cookies [required]
     */
    public function setCookies(array $cookies): void
    {
    }

    /**
     * @param string|array $data [required]
     */
    public function setData($data): void
    {
    }

    /**
     * @param string $path [required]
     * @param string $name [required]
     * @param string|null $type [optional]
     * @param string|null $filename [optional]
     * @param int $offset [optional]
     * @param int $length [optional]
     */
    public function addFile(string $path, string $name, ?string $type = null, ?string $filename = null, int $offset = 0, int $length = 0): void
    {
    }

    /**
     * @param string $path [required]
     * @param string $name [required]
     * @param string|null $type [optional]
     * @param string|null $filename [optional]
     */
    public function addData(string $path, string $name, ?string $type, ?string $filename): void
    {
    }

    /**
     * @param string $path [required]
     * @return int|bool
     */
    public function execute(string $path)
    {
    }

    /**
     * @return array|false
     */
    public function getpeername()
    {
    }

    /**
     * @return array|false
     */
    public function getsockname()
    {
    }

    /**
     * @param string $path [required]
     */
    public function get(string $path): void
    {
    }

    /**
     * @param mixed $path [required]
     * @param string|array $data [required]
     */
    public function post(string $path, $data): void
    {
    }

    /**
     * @param string $path [required]
     * @param string $file [required]
     * @param int $offset [optional]
     */
    public function download(string $path, string $file, int $offset = 0): bool
    {
    }

    /**
     * @return string|bool
     */
    public function getBody()
    {
    }

    /**
     * @return array|bool
     */
    public function getHeaders()
    {
    }

    /**
     * @return array|bool
     */
    public function getCookies()
    {
    }

    /**
     * @return int|bool
     */
    public function getStatusCode()
    {
    }

    /**
     * @return string|bool
     */
    public function getHeaderOut()
    {
    }

    /**
     * @return string|false
     */
    public function getPeerCert()
    {
    }

    /**
     * @param string $path [required]
     */
    public function upgrade(string $path): bool
    {
    }

    /**
     * @param mixed $data [required]
     * @param int $opcode [optional]
     * @param int $flags [optional]
     */
    public function push($data, int $opcode = \OpenSwoole\WebSocket\Server::WEBSOCKET_OPCODE_TEXT, int $flags = \OpenSwoole\WebSocket\Server::WEBSOCKET_FLAG_FIN): bool
    {
    }

    /**
     * @param mixed $timeout [optional]
     * @return bool|Frame
     */
    public function recv(float $timeout = 0)
    {
    }

    public function close(): bool
    {
    }
}

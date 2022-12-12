<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine;

final class Client
{
    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 128;

    public const MSG_WAITALL = 64;

    public $errCode;

    public $errMsg;

    public $fd;

    public $type;

    public $setting;

    public $connected;

    private $socket;

    /**
     * @param int $type [required]
     */
    public function __construct(int $type)
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

    /**
     * @param string $host [required]
     * @param int $port [optional] = 0
     * @param float $timeout [optional] = 0.5
     * @param int $sockFlag [optional] = 0
     */
    public function connect(string $host, int $port = 0, float $timeout = 0.5, int $sockFlag = 0): bool
    {
    }

    /**
     * @param float $timeout [optional] = 1
     */
    public function recv(float $timeout = 1): string
    {
    }

    /**
     * @param int $length [optional] = 65535
     */
    public function peek(int $length = 65535): string
    {
    }

    /**
     * @param string $data [required]
     * @param float $timeout [optional] = 1
     */
    public function send(string $data, float $timeout = 1)
    {
    }

    /**
     * @param string $fileName [required]
     * @param int $offset [optional] = 0
     * @param int $length [optional] = 0
     */
    public function sendfile(string $fileName, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * @param string $host [required]
     * @param int $port [required]
     * @param string $data [required]
     */
    public function sendto(string $host, int $port, string $data): bool
    {
    }

    /**
     * @param int $length [required]
     * @param mixed $host [required]
     * @param mixed $port [optional] = 0
     */
    public function recvfrom(int $length, &$host, &$port = 0): string
    {
    }

    public function enableSSL(): bool
    {
    }

    public function getPeerCert(): string
    {
    }

    /**
     * @param bool $allowSelfSigned [optional] = false
     */
    public function verifyPeerCert(bool $allowSelfSigned = false): bool
    {
    }

    public function isConnected(): bool
    {
    }

    public function getsockname()
    {
    }

    public function getpeername()
    {
    }

    public function close(): bool
    {
    }

    /**
     * @return Socket|bool
     */
    public function exportSocket()
    {
    }
}

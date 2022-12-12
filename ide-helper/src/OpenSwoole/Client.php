<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

class Client
{
    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 128;

    public const MSG_WAITALL = 64;

    public const SHUT_RDWR = 2;

    public const SHUT_RD = 0;

    public const SHUT_WR = 1;

    public $errCode;

    public $sock;

    public $reuse;

    public $reuseCount;

    public $type;

    public $id;

    public $setting;

    /**
     * @param int $sockType [required]
     * @param bool $async [optional] = false
     * @param string $id [optional] = ''
     */
    public function __construct(int $sockType, bool $async = false, string $id = '')
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
     * @param int $port [required]
     * @param float $timeout [optional] = 0.5
     * @param int $sockFlag [optional] = 0
     */
    public function connect(string $host, int $port, float $timeout = 0.5, int $sockFlag = 0): bool
    {
    }

    /**
     * @param int $length [optional] = 65535
     * @param int $flags [optional] = 0
     */
    public function recv(int $length = 65535, int $flags = 0): string
    {
    }

    /**
     * @param string $data [required]
     * @param int $flags [optional] = 0
     */
    public function send(string $data, int $flags = 0)
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
     * @param string $ip [required]
     * @param int $port [required]
     * @param string $data [required]
     */
    public function sendto(string $ip, int $port, string $data): bool
    {
    }

    /**
     * @param int $how [required]
     */
    public function shutdown(int $how): bool
    {
    }

    public function enableSSL(): bool
    {
    }

    public function getPeerCert(): string
    {
    }

    public function verifyPeerCert(): bool
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

    /**
     * @param bool $force [optional] = false
     */
    public function close(bool $force = false): bool
    {
    }

    public static function select(array &$readReady, array &$writeReady, array &$errors, float $timeout = 0.5): bool
    {
    }
}

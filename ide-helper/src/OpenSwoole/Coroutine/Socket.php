<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine;

use const IPPROTO_IP;

class Socket
{
    public const EVENT_READ = 512;

    public const EVENT_WRITE = 1024;

    public $fd;

    public $domain;

    public $type;

    public $protocol;

    public $errCode;

    public $errMsg;

    /**
     * @param int $domain [required]
     * @param int $type [required]
     * @param int $protocol [optional] = \IPPROTO_IP
     */
    public function __construct(int $domain, int $type, int $protocol = IPPROTO_IP)
    {
    }

    /**
     * @param string $address [required]
     * @param int $port [optional] = 0
     */
    public function bind(string $address, int $port = 0): bool
    {
    }

    /**
     * @param int $backlog [optional] = 512
     */
    public function listen(int $backlog = 512): bool
    {
    }

    /**
     * @param float $timeout [optional] = 0
     */
    public function accept(float $timeout = 0)
    {
    }

    /**
     * @param string $host [required]
     * @param int $port [optional] = 0
     * @param float $timeout [optional] = 0
     */
    public function connect(string $host, int $port = 0, float $timeout = 0): mixed
    {
    }

    public function checkLiveness(): bool
    {
    }

    /**
     * @param int $length [optional] = 65536
     */
    public function peek(int $length = 65536): string
    {
    }

    /**
     * @param int $length [optional] = 65536
     * @param float $timeout [optional] = 0
     */
    public function recv(int $length = 65536, float $timeout = 0): string
    {
    }

    /**
     * @param int $length [optional] = 65536
     * @param float $timeout [optional] = 0
     */
    public function recvAll(int $length = 65536, float $timeout = 0): string
    {
    }

    /**
     * @param int $length [optional] = 65536
     * @param float $timeout [optional] = 0
     */
    public function recvLine(int $length = 65536, float $timeout = 0): string
    {
    }

    /**
     * @param int $length [optional] = 65536
     * @param float $timeout [optional] = 0
     */
    public function recvWithBuffer(int $length = 65536, float $timeout = 0): string
    {
    }

    /**
     * @param float $timeout [optional] = 0
     */
    public function recvPacket(float $timeout = 0): string
    {
    }

    /**
     * @param string $data [required]
     * @param float $timeout [optional] = 0
     */
    public function send(string $data, float $timeout = 0)
    {
    }

    /**
     * @param array $ioVector [required]
     * @param float $timeout [optional] = 0
     */
    public function readVector(array $ioVector, float $timeout = 0)
    {
    }

    /**
     * @param array $ioVector [required]
     * @param float $timeout [optional] = 0
     */
    public function readVectorAll(array $ioVector, float $timeout = 0)
    {
    }

    /**
     * @param array $ioVector [required]
     * @param float $timeout [optional] = 0
     */
    public function writeVector(array $ioVector, float $timeout = 0)
    {
    }

    /**
     * @param array $ioVector [required]
     * @param float $timeout [optional] = 0
     */
    public function writeVectorAll(array $ioVector, float $timeout = 0)
    {
    }

    /**
     * @param string $fileName [required]
     * @param int $offset [optional] = 0
     * @param int $length [optional] = 0
     */
    public function sendFile(string $fileName, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * @param string $data [required]
     * @param float $timeout [optional] = 0
     */
    public function sendAll(string $data, float $timeout = 0)
    {
    }

    /**
     * @param mixed $peerName [required]
     * @param float $timeout [optional] = 0
     */
    public function recvfrom(&$peerName, float $timeout = 0): string
    {
    }

    /**
     * @param string $addr [required]
     * @param int $port [required]
     * @param string $data [required]
     */
    public function sendto(string $addr, int $port, string $data)
    {
    }

    /**
     * @param int $level [required]
     * @param int $name [required]
     */
    public function getOption(int $level, int $name): mixed
    {
    }

    /**
     * @param array $settings [required]
     */
    public function setProtocol(array $settings): bool
    {
    }

    /**
     * @param int $level [required]
     * @param int $name [required]
     * @param mixed $value [required]
     */
    public function setOption(int $level, int $name, $value): bool
    {
    }

    /**
     * @param int $how [optional] = 0
     */
    public function shutdown(int $how = 0): bool
    {
    }

    /**
     * @param int $event [optional] = \SWOOLE_EVENT_READ
     */
    public function cancel(int $event = Socket::EVENT_READ): bool
    {
    }

    public function close(): bool
    {
    }

    /**
     * @return bool|array
     */
    public function getpeername()
    {
    }

    /**
     * @return bool|array
     */
    public function getsockname()
    {
    }
}

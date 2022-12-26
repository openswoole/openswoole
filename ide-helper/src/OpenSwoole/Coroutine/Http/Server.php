<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine\Http;

final class Server
{
    public int $fd;

    public string $host;

    public int $port;

    public bool $ssl;

    public ?array $settings;

    public int $errCode;

    public string $errMsg;

    /**
     * @param string $host [required]
     * @param int $port [optional]
     * @param bool $ssl [optional]
     * @param bool $reuse_port [optional]
     */
    public function __construct(string $host, int $port = 0, bool $ssl = false, bool $reuse_port = false)
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
     * @param string $pattern [required]
     * @param callable $callback [required]
     */
    public function handle(string $pattern, callable $callback): void
    {
    }

    public function start(): void
    {
    }

    public function shutdown(): void
    {
    }

    /**
     * @return mixed
     */
    private function onAccept()
    {
    }
}

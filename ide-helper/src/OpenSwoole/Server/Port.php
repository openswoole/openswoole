<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Server;

final class Port
{
    public $host;

    public $port;

    public $type;

    public $sock;

    public $setting;

    public $connections;

    private $onConnect;

    private $onReceive;

    private $onClose;

    private $onPacket;

    private $onBufferFull;

    private $onBufferEmpty;

    private $onRequest;

    private $onHandShake;

    private $onOpen;

    private $onMessage;

    private $onDisconnect;

    private function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param array $settings [required]
     * @return ?bool
     */
    public function set(array $settings): ?bool
    {
    }

    /**
     * @param string $event [required]
     * @param callable $callback [required]
     */
    public function on(string $event, callable $callback): bool
    {
    }

    /**
     * @param string $event [required]
     * @return ?callable
     */
    public function getCallback(string $event): ?callable
    {
    }

    public function handle(callable $callback): bool
    {
    }

    /**
     * @param mixed $handler
     */
    public function setHandler($handler): bool
    {
    }
}

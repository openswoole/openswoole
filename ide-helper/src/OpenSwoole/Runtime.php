<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

class Runtime
{
    public const HOOK_TCP = 2;

    public const HOOK_UDP = 4;

    public const HOOK_UNIX = 8;

    public const HOOK_UDG = 16;

    public const HOOK_SSL = 32;

    public const HOOK_TLS = 64;

    public const HOOK_STREAM_FUNCTION = 128;

    public const HOOK_STREAM_SELECT = 128;

    public const HOOK_FILE = 256;

    public const HOOK_STDIO = 32768;

    public const HOOK_SLEEP = 512;

    public const HOOK_PROC = 1024;

    public const HOOK_CURL = 2048;

    public const HOOK_NATIVE_CURL = 4096;

    public const HOOK_BLOCKING_FUNCTION = 8192;

    public const HOOK_SOCKETS = 16384;

    public const HOOK_ALL = 2147481599;

    /**
     * @param bool $enable [optional] = true
     * @param int $flags [optional] = Runtime::HOOK_ALL
     */
    public static function enableCoroutine(bool $enable = true, int $flags = Runtime::HOOK_ALL): void
    {
    }

    public static function getHookFlags(): int
    {
    }

    /**
     * @param int $flags [optional] = Runtime::HOOK_ALL
     */
    public static function setHookFlags(int $flags = Runtime::HOOK_ALL): void
    {
    }
}

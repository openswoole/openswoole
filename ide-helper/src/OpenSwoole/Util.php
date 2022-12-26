<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

class Util
{
    public static function getVersion(): string
    {
    }

    public static function getCPUNum(): int
    {
    }

    public static function getLocalIp(): array
    {
    }

    public static function getLocalMac(): array
    {
    }

    public static function getLastErrorCode(): int
    {
    }

    public static function getErrorMessage(int $errorCode, ?int $errorType): string
    {
    }

    public static function errorCode(): int
    {
    }

    public static function clearError(): void
    {
    }

    public static function log(int $level, string $message): void
    {
    }

    /**
     * @return int|bool
     */
    public static function hashcode(string $content, int $type)
    {
    }

    public static function mimeTypeAdd(string $suffix, string $mimeType): bool
    {
    }

    public static function mimeTypeSet(string $suffix, string $mimeType): bool
    {
    }

    public static function mimeTypeDel(string $suffix): bool
    {
    }

    public static function mimeTypeGet(string $filename): string
    {
    }

    public static function mimeTypeList(): array
    {
    }

    public static function mimeTypeExists(string $filename): string
    {
    }

    public static function setProcessName(string $name): void
    {
    }

    public static function setAio(array $settings): bool
    {
    }
}

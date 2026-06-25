<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Http;

final class Request
{
    public int $fd;

    public array $header;

    public array $server;

    public array $cookie;

    public ?array $get;

    public ?array $files;

    public ?array $post;

    public ?array $tmpfiles;

    public function __destruct()
    {
    }

    public function rawContent(): bool|string
    {
    }

    public function getContent(): bool|string
    {
    }

    public function getData(): bool|string
    {
    }

    /**
     * @param array|null $options [required]
     */
    public static function create(?array $options): Request|bool
    {
    }

    /**
     * @param string $data [required]
     */
    public function parse(string $data): int|false
    {
    }

    public function isCompleted(): bool
    {
    }

    public function getMethod(): bool|string
    {
    }
}

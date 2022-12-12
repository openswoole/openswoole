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

    /**
     * @return string|bool
     */
    public function rawContent()
    {
    }

    /**
     * @return string|bool
     */
    public function getContent()
    {
    }

    /**
     * @return string|bool
     */
    public function getData()
    {
    }

    /**
     * @param array|null $options [required]
     * @return Request|bool
     */
    public static function create(?array $options)
    {
    }

    /**
     * @param string $data [required]
     * @return int|false
     */
    public function parse(string $data)
    {
    }

    public function isCompleted(): bool
    {
    }

    /**
     * @return string|bool
     */
    public function getMethod()
    {
    }
}

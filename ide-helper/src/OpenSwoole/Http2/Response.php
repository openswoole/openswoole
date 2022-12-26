<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Http2;

class Response
{
    public int $streamId = 0;

    public int $errCode = 0;

    public int $statusCode = 0;

    public bool $pipeline = false;

    public ?array $headers;

    public $set_cookie_headers;

    public ?array $cookies;

    public $data;
}

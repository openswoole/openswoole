<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole IDE Helper.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */
namespace OpenSwoole\Http2;

class Request
{
    public string $path = '/';

    public string $method = 'GET';

    public ?array $headers;

    public ?array $cookies;

    public string $data = '';

    public bool $pipeline = false;
}

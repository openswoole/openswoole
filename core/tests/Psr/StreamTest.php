<?php
/**
 * This file is part of Open Swoole.
 *
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace OpenSwoole\Core\Psr7Test\Tests;

use Http\Psr7Test\StreamIntegrationTest;
use Psr\Http\Message\StreamInterface;
use OpenSwoole\Core\Psr\Stream;

/**
 * @internal
 * @coversNothing
 */
class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        if ($data instanceof StreamInterface) {
            return $data;
        }

        return new Stream($data);
    }
}

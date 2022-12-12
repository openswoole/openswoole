<?php
/**
 * This file is part of Open Swoole.
 *
 * @see     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Psr7Test\Tests;

use Http\Psr7Test\UriIntegrationTest;
use OpenSwoole\Core\Psr\Uri;

/**
 * @internal
 * @coversNothing
 */
class UriTest extends UriIntegrationTest
{
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}

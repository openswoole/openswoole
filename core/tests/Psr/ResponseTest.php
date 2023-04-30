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

use Http\Psr7Test\ResponseIntegrationTest;
use OpenSwoole\Core\Psr\Response;

/**
 * @internal
 * @coversNothing
 */
class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response('', 200, '', ['X-Foo' => 'Bar']);
    }

    public function testCreationWillSetHeaders(): void
    {
        $response = $this->createSubject();

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('OK', $response->getReasonPhrase());
        self::assertEquals(['x-foo' => ['Bar']], $response->getHeaders());
    }
}

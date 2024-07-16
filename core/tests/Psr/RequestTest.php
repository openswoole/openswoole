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

use Http\Psr7Test\RequestIntegrationTest;
use OpenSwoole\Core\Psr\Request;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 * @coversNothing
 */
class RequestTest extends RequestIntegrationTest
{
    public function createSubject(): RequestInterface
    {
        return new Request('/', 'GET', null, ['X-Foo' => 'Bar']);
    }

    public function testGetHeader(): void
    {
        $this->assertEquals(['Bar'], $this->request->getHeader('X-Foo'));
    }

    public function testGetHeadersMaintainsCase(): void
    {
        $this->assertEquals(['X-Foo' => ['Bar']], $this->request->getHeaders());
    }

    public function testZeroValueHeaderIsValid(): void
    {
        $request = new Request('/', 'GET', null, ['content-length' => '0']);
        $this->assertEquals(['0'], $request->getHeader('content-length'));
    }
}

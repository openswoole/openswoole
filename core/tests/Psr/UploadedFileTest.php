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

use Http\Psr7Test\UploadedFileIntegrationTest;
use OpenSwoole\Core\Psr\Stream;
use OpenSwoole\Core\Psr\UploadedFile;

/**
 * @internal
 * @coversNothing
 */
class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $stream = new Stream('php://memory', 'rw');
        $stream->write('foobar');

        return new UploadedFile($stream, $stream->getSize(), UPLOAD_ERR_OK);
    }
}

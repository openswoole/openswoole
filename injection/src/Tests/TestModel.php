<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Tests;

class TestModel
{
    private $test;

    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test): void
    {
        $this->test = $test;
    }
}

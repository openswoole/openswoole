<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Injection\Tests;

class TestClass
{
    private TestModel $testModel;

    public function __construct(TestModel $testModel)
    {
        $this->testModel = $testModel;
    }

    public function getTestModel(): TestModel
    {
        return $this->testModel;
    }
}

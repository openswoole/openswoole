<?php

namespace OpenSwoole\Injection\Tests;

class TestClass
{
    private TestModel $testModel;

    public function __construct(TestModel $testModel)
    {
        $this->testModel = $testModel;
    }

    /**
     * @return TestModel
     */
    public function getTestModel(): TestModel
    {
        return $this->testModel;
    }
}
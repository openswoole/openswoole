<?php

namespace OpenSwoole\Injection\Tests;

class TestModel
{
    private $test;

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test): void
    {
        $this->test = $test;
    }
}
<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../../vendor/autoload.php';


$container = new \OpenSwoole\Injection\Container();
var_dump($container);
$testClass = $container->get(\OpenSwoole\Injection\Tests\TestClass::class);
$testClass->getTestModel()->setTest("test");
echo $testClass->getTestModel()->getTest();

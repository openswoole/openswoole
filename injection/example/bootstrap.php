<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../vendor/autoload.php';

use OpenSwoole\Injection\Container;
use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use OpenSwoole\Injection\Exceptions\NotFoundException;
use OpenSwoole\Injection\Tests\TestClass;
use OpenSwoole\Injection\Tests\TestModel;

/*
 * Demo fixtures defined inline so the example stays runnable without adding
 * an autoload path. In real code these would be ordinary classes.
 */

interface LoggerInterface
{
    public function log(string $message): string;
}

final class EchoLogger implements LoggerInterface
{
    public function log(string $message): string
    {
        return "[echo] {$message}";
    }
}

final class PrefixLogger implements LoggerInterface
{
    public function log(string $message): string
    {
        return "[prefix] {$message}";
    }
}

// Depends on an interface — only resolvable once the interface is bound.
final class Service
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function run(): string
    {
        return $this->logger->log('running');
    }
}

// Has a scalar parameter with a default — autowiring should use the default.
final class Greeter
{
    public function __construct(public string $greeting = 'hello')
    {
    }
}

// Has a scalar parameter with NO default — autowiring must fail.
final class NeedsScalar
{
    public function __construct(public string $required)
    {
    }
}

// Carries a runtime config value; a natural fit for a factory closure.
final class Connection
{
    public function __construct(public string $dsn)
    {
    }
}

/* ----------------------------------------------------------------------- */

$container = new Container();

// 1. Autowiring — resolve a class graph with zero config'
$testClass = $container->get(TestClass::class);
$testClass->getTestModel()->setTest('autowired');
echo 'TestClass->TestModel->getTest(): ' . $testClass->getTestModel()->getTest() . "\n";

// 2. Singleton caching — same id returns the same instance';
$a = $container->get(TestModel::class);
$b = $container->get(TestModel::class);
echo 'Singleton same instance? ' . ($a === $b ? 'yes' : 'no') . "\n";


// 2b. Transient binding — same id returns a new instance each time';
$container->transient(TestModel::class);
$transientA = $container->get(TestModel::class);
$transientB = $container->get(TestModel::class);
echo 'Transient same instance? ' . ($transientA === $transientB ? 'yes' : 'no') . "\n";


// 3. Interface binding — map an interface to an implementation';
$container->singleton(LoggerInterface::class, EchoLogger::class);
$service = $container->get(Service::class);
echo $service->run() . "\n";

// 4. Rebinding — set() swaps the impl and clears the cached singleton';
$container->set(LoggerInterface::class, PrefixLogger::class);
echo 'Logger is now: ' . get_class($container->get(LoggerInterface::class)) . "\n";
// Note: Service was already resolved & cached in #3, so it keeps EchoLogger.
echo 'Cached Service still uses old logger: ' . $service->run() . "\n";

// 5. Factory closure — build a service that needs a runtime value';
$container->set(Connection::class, fn(Container $c) => new Connection('mysql://localhost/app'));
echo 'Connection dsn: ' . $container->get(Connection::class)->dsn . "\n";

// 6. Default scalar parameter — autowiring uses the default value';
echo 'Greeter greeting: ' . $container->get(Greeter::class)->greeting . "\n";

// 7. has() — bound, resolved, autowirable, and unknown';
echo 'has(LoggerInterface) [bound]      : ' . var_export($container->has(LoggerInterface::class), true) . "\n";
echo 'has(TestModel)       [transient]  : ' . var_export($container->has(TestModel::class), true) . "\n";
echo 'has(Greeter)         [autowirable]: ' . var_export($container->has(Greeter::class), true) . "\n";
echo 'has("No\\\\Such\\\\Class")  [unknown]    : ' . var_export($container->has('No\\Such\\Class'), true) . "\n";

// 8. NotFoundException — get() on an unknown class id');
try {
    $container->get('No\\Such\\Class');
} catch (NotFoundException $e) {
    echo 'Caught NotFoundException: ' . $e->getMessage() . "\n";
}

// 9. Unresolvable scalar — constructor arg with no default');
try {
    $container->get(NeedsScalar::class);
} catch (DependencyHasNoDefaultValueException $e) {
    echo 'Caught DependencyHasNoDefaultValueException: ' . $e->getMessage() . "\n";
}

// 10. Bad factory — a closure that does not return an object');
$container->set('bad', fn() => 42);
try {
    $container->get('bad');
} catch (DependencyIsNotInstantiableException $e) {
    echo 'Caught DependencyIsNotInstantiableException: ' . $e->getMessage() . "\n";
}




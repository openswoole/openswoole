<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../vendor/autoload.php';

use OpenSwoole\Injection\Container;
use OpenSwoole\Injection\Exceptions\CircularDependencyException;
use OpenSwoole\Injection\Exceptions\DependencyHasNoDefaultValueException;
use OpenSwoole\Injection\Exceptions\DependencyIsNotInstantiableException;
use OpenSwoole\Injection\Exceptions\NotFoundException;

$container = new Container();

/* -----------------------------------------------------------------------
 | 1. Autowiring — resolve a class graph with zero config
 * ---------------------------------------------------------------------*/

final class DemoModel
{
    private $value;

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

final class DemoService
{
    public function __construct(private DemoModel $model)
    {
    }

    public function getModel(): DemoModel
    {
        return $this->model;
    }
}

$demoService = $container->get(DemoService::class);
$demoService->getModel()->setValue('autowired');

echo 'DemoService->DemoModel->getValue(): '
    . $demoService->getModel()->getValue()
    . "\n";

/* -----------------------------------------------------------------------
 | 2. Singleton caching — same id returns the same instance
 * ---------------------------------------------------------------------*/

$a = $container->get(DemoModel::class);
$b = $container->get(DemoModel::class);

echo 'Singleton same instance? '
    . ($a === $b ? 'yes' : 'no')
    . "\n";

/* -----------------------------------------------------------------------
 | 3. Transient binding — same id returns a new instance each time
 * ---------------------------------------------------------------------*/

$container->transient(DemoModel::class);

$transientA = $container->get(DemoModel::class);
$transientB = $container->get(DemoModel::class);

echo 'Transient same instance? '
    . ($transientA === $transientB ? 'yes' : 'no')
    . "\n";

/* -----------------------------------------------------------------------
 | 4. Scoped binding — same instance within the current scope
 * ---------------------------------------------------------------------*/

final class RequestContext
{
}

$container->scoped(RequestContext::class);

$scopeA = $container->get(RequestContext::class);
$scopeB = $container->get(RequestContext::class);

echo 'Scoped same instance? '
    . ($scopeA === $scopeB ? 'yes' : 'no')
    . "\n";

$container->clearScope();

$scopeC = $container->get(RequestContext::class);

echo 'Scoped after clearScope same instance? '
    . ($scopeA === $scopeC ? 'yes' : 'no')
    . "\n";

/* -----------------------------------------------------------------------
 | 5. Interface binding — map an interface to an implementation
 * ---------------------------------------------------------------------*/

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

$container->singleton(LoggerInterface::class, EchoLogger::class);

$service = $container->get(Service::class);

echo $service->run() . "\n";

/* -----------------------------------------------------------------------
 | 6. Rebinding — set() swaps implementation and clears cached singleton
 * ---------------------------------------------------------------------*/

$container->set(LoggerInterface::class, PrefixLogger::class);

echo 'Logger is now: '
    . get_class($container->get(LoggerInterface::class))
    . "\n";

// Service was already resolved and cached, so it still keeps EchoLogger.
echo 'Cached Service still uses old logger: '
    . $service->run()
    . "\n";

/* -----------------------------------------------------------------------
 | 7. Factory closure — build a service with runtime config
 * ---------------------------------------------------------------------*/

final class Connection
{
    public function __construct(public string $dsn)
    {
    }
}

$container->set(
    Connection::class,
    fn (Container $c) => new Connection('mysql://localhost/app')
);

echo 'Connection dsn: '
    . $container->get(Connection::class)->dsn
    . "\n";

/* -----------------------------------------------------------------------
 | 8. Default scalar parameter — autowiring uses the default value
 * ---------------------------------------------------------------------*/

final class Greeter
{
    public function __construct(public string $greeting = 'hello')
    {
    }
}

echo 'Greeter greeting: '
    . $container->get(Greeter::class)->greeting
    . "\n";

/* -----------------------------------------------------------------------
 | 9. has() — bound, resolved, autowirable, and unknown
 * ---------------------------------------------------------------------*/

echo 'has(LoggerInterface) [bound]      : '
    . var_export($container->has(LoggerInterface::class), true)
    . "\n";

echo 'has(DemoModel)       [transient]  : '
    . var_export($container->has(DemoModel::class), true)
    . "\n";

echo 'has(Greeter)         [autowirable]: '
    . var_export($container->has(Greeter::class), true)
    . "\n";

echo 'has("No\\\Such\\\Class") [unknown]    : '
    . var_export($container->has('No\Such\Class'), true)
    . "\n";

/* -----------------------------------------------------------------------
 | 10. NotFoundException — get() on an unknown class id
 * ---------------------------------------------------------------------*/

try {
    $container->get('No\Such\Class');
} catch (NotFoundException $e) {
    echo 'Caught NotFoundException: '
        . $e->getMessage()
        . "\n";
}

/* -----------------------------------------------------------------------
 | 11. Unresolvable scalar — constructor arg with no default
 * ---------------------------------------------------------------------*/

final class NeedsScalar
{
    public function __construct(public string $required)
    {
    }
}

try {
    $container->get(NeedsScalar::class);
} catch (DependencyHasNoDefaultValueException $e) {
    echo 'Caught DependencyHasNoDefaultValueException: '
        . $e->getMessage()
        . "\n";
}

/* -----------------------------------------------------------------------
 | 12. Bad factory — closure does not return an object
 * ---------------------------------------------------------------------*/

$container->set('bad', fn () => 42);

try {
    $container->get('bad');
} catch (DependencyIsNotInstantiableException $e) {
    echo 'Caught DependencyIsNotInstantiableException: '
        . $e->getMessage()
        . "\n";
}

/* -----------------------------------------------------------------------
 | 13. Circular dependency — fail fast with dependency path
 * ---------------------------------------------------------------------*/

final class CircularA
{
    public function __construct(CircularB $b)
    {
    }
}

final class CircularB
{
    public function __construct(CircularA $a)
    {
    }
}

try {
    $container->get(CircularA::class);
} catch (CircularDependencyException $e) {
    echo 'Caught CircularDependencyException: '
        . $e->getMessage()
        . "\n";
}

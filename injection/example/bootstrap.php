<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../vendor/autoload.php';

use OpenSwoole\Injection\Disposable;
use OpenSwoole\Injection\Exceptions\ScopeViolationException;
use OpenSwoole\Injection\ServiceCollection;

final class DemoModel
{
}
final class DemoService
{
    public function __construct(public DemoModel $model)
    {
    }
}

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
final class RequestContext implements Disposable
{
    public function dispose(): void
    {
        echo "RequestContext disposed\n";
    }
}

$services = new ServiceCollection();
$services
    ->singleton(LoggerInterface::class, EchoLogger::class)
    ->scoped(RequestContext::class)
    ->transient(DemoModel::class)
;

$provider = $services->build();
$scope    = $provider->createScope();

echo 'Autowired model: ' . get_class($scope->get(DemoService::class)->model) . "\n";
echo 'Transient instances are different: '
    . ($scope->get(DemoModel::class) !== $scope->get(DemoModel::class) ? 'yes' : 'no') . "\n";
echo 'Scoped instances are shared: '
    . ($scope->get(RequestContext::class) === $scope->get(RequestContext::class) ? 'yes' : 'no') . "\n";

$scope->close();

require_once __DIR__ . '/services/DocBlockService.php';
if (PHP_MAJOR_VERSION >= 8) {
    require_once __DIR__ . '/services/AttributeService.php';
}

$scanned = (new ServiceCollection())
    ->scan(__DIR__ . '/services', 'OpenSwoole\Injection\ExampleServices')
    ->build()
;

echo 'Scanned DocBlock service: '
    . get_class($scanned->get('OpenSwoole\Injection\ExampleServices\DocBlockService')) . "\n";
if (PHP_MAJOR_VERSION >= 8) {
    echo 'Scanned attribute service: '
        . get_class($scanned->get('OpenSwoole\Injection\ExampleServices\AttributeService')) . "\n";
}

final class ScopedDependency
{
}
final class SingletonDependingOnScoped
{
    public function __construct(ScopedDependency $dependency)
    {
    }
}

$invalid = (new ServiceCollection())->scoped(ScopedDependency::class)->build();
try {
    $invalid->get(SingletonDependingOnScoped::class);
} catch (ScopeViolationException $exception) {
    echo 'Caught ScopeViolationException: ' . $exception->getMessage() . "\n";
}

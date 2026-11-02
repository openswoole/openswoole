<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
use OpenSwoole\Injection\Disposable;
use OpenSwoole\Injection\ExampleServices\AttributeService;
use OpenSwoole\Injection\Exceptions\ScopeViolationException;
use OpenSwoole\Injection\ServiceCollection;

require_once is_file(__DIR__ . '/../vendor/autoload.php')
    ? __DIR__ . '/../vendor/autoload.php'
    : __DIR__ . '/../../vendor/autoload.php';

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

final class DemoModel
{
}

final class DemoService
{
    public function __construct(public DemoModel $model, public LoggerInterface $logger)
    {
    }
}

final class RequestContext implements Disposable
{
    public function dispose(): void
    {
        echo "RequestContext disposed\n";
    }
}

final class SingletonDependingOnScoped
{
    public function __construct(RequestContext $context)
    {
    }
}

// Register application services and discover attributed services before building the provider.
$provider = (new ServiceCollection())
    ->singleton(LoggerInterface::class, EchoLogger::class)
    ->scoped(RequestContext::class)
    ->transient(DemoModel::class)
    ->scan(__DIR__ . '/services', 'OpenSwoole\Injection\ExampleServices')
    ->build();

try {
    $scope = $provider->createScope();
    try {
        $service = $scope->get(DemoService::class);
        echo $service->logger->log('Autowired model: ' . $service->model::class) . "\n";
        echo 'Transient instances are different: '
            . ($scope->get(DemoModel::class) !== $scope->get(DemoModel::class) ? 'yes' : 'no') . "\n";
        echo 'Scoped instances are shared: '
            . ($scope->get(RequestContext::class) === $scope->get(RequestContext::class) ? 'yes' : 'no') . "\n";
    } finally {
        $scope->close();
    }

    echo 'Scanned attribute service: ' . $provider->get(AttributeService::class)::class . "\n";

    // An autowired singleton cannot depend on request-scoped state.
    try {
        $provider->get(SingletonDependingOnScoped::class);
    } catch (ScopeViolationException $exception) {
        echo 'Caught ScopeViolationException: ' . $exception->getMessage() . "\n";
    }
} finally {
    $provider->close();
}

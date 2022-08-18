<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole RPC.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/grpc/blob/main/LICENSE
 */
namespace OpenSwoole\GRPC;

use OpenSwoole\GRPC\Exception\InvokeException;

final class ServiceContainer
{
    private string $name;

    private ServiceInterface $service;

    private array $methods;

    public function __construct(string $interface, ServiceInterface $service)
    {
        try {
            $reflection = new \ReflectionClass($interface);

            if (!$reflection->hasConstant('NAME')) {
                \swoole_error_log(\SWOOLE_LOG_ERROR, "Can't find NAME of the service: {$interface}");
            }

            $name = $reflection->getConstant('NAME');

            if (!\is_string($name)) {
                \swoole_error_log(\SWOOLE_LOG_ERROR, "Can't find NAME of the service: {$interface}");
            }

            $this->name = $name;
        } catch (\ReflectionException $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }

        if (!$service instanceof $interface) {
        }

        $this->service = $service;

        $this->methods = $this->discoverMethods($service);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getService(): ServiceInterface
    {
        return $this->service;
    }

    public function getMethods(): array
    {
        return array_values($this->methods);
    }

    public function invoke(Request $request): string
    {
        $method  = $request->getMethod();
        $context = $request->getContext();
        $input   = $request->getPayload();
        if (!isset($this->methods[$method])) {
        }

        $callable = [$this->service, $method];

        $class = $this->methods[$method]['inputClass']->getName();

        $message = new $class();

        if ($input !== null) {
            if ($context->getValue('content-type') !== 'application/grpc+json') {
                $message->mergeFromString($input);
            } else {
                $message->mergeFromJsonString($input);
            }
        }

        try {
            $result = $callable($context, $message);
        } catch (\TypeError $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }

        try {
            if ($context->getValue('content-type') !== 'application/grpc+json') {
                $output = $result->serializeToString();
            } else {
                $output = $result->serializeToJsonString();
            }
        } catch (\Throwable $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }

        return $output;
    }

    private function discoverMethods(ServiceInterface $service): array
    {
        $reflection = new \ReflectionObject($service);

        $methods = [];
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getNumberOfParameters() !== 2) {
                throw new \Exception('error method');
            }

            [, $input] = $method->getParameters();

            $methods[$method->getName()] = ['name' => $method->getName(), 'inputClass' => $input->getType(), 'returnClass' => $method->getReturnType()];
        }

        return $methods;
    }
}

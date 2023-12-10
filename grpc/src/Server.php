<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\GRPC;

use Closure;
use OpenSwoole\GRPC\Exception\GRPCException;
use OpenSwoole\GRPC\Exception\InvokeException;
use OpenSwoole\GRPC\Middleware\MiddlewareInterface;
use OpenSwoole\GRPC\Middleware\ServiceHandler;
use OpenSwoole\GRPC\Middleware\StackHandler;
use OpenSwoole\Util;
use Throwable;
use TypeError;

final class Server
{
    private string $host;

    private int $port;

    private int $mode;

    private int $sockType;

    /**
     * @psalm-suppress UndefinedClass
     */
    private array $settings = [
        \OpenSwoole\Constant::OPTION_OPEN_HTTP2_PROTOCOL => 1,
        \OpenSwoole\Constant::OPTION_ENABLE_COROUTINE    => true,
    ];

    private array $services = [];

    private array $workerContexts = [];

    private $server;

    private $handler;

    private $workerContext;

    public function __construct(string $host, int $port = 0, int $mode = \OpenSwoole\Server::SIMPLE_MODE, int $sockType = \OpenSwoole\Constant::SOCK_TCP)
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->mode     = $mode;
        $this->sockType = $sockType;
        $server         = new \OpenSwoole\HTTP\Server($this->host, $this->port, $this->mode, $this->sockType);
        $server->on('start', function () {
            Util::LOG(\OpenSwoole\Constant::LOG_INFO, sprintf("\033[32m%s\033[0m", "OpenSwoole GRPC Server is started grpc://{$this->host}:{$this->port}"));
        });
        $this->server   = $server;

        $handler       = (new StackHandler())->add(new ServiceHandler());
        $this->handler = $handler;

        return $this;
    }

    public function withWorkerContext(string $context, Closure $callback): self
    {
        $this->workerContexts[$context] = $callback;
        return $this;
    }

    public function addMiddleware(MiddlewareInterface $middleware): self
    {
        $this->handler = $this->handler->add($middleware);
        return $this;
    }

    public function set(array $settings): self
    {
        $this->settings = array_merge($this->settings, $settings ?? []);
        return $this;
    }

    public function start()
    {
        $this->server->set($this->settings);
        $this->server->on('workerStart', function (\OpenSwoole\Server $server, int $workerId) {
            $this->workerContext = new Context([
                \OpenSwoole\GRPC\Server::class              => $this,
                \OpenSwoole\HTTP\Server::class              => $this->server,
            ]);
            foreach ($this->workerContexts as $context => $callback) {
                $this->workerContext = $this->workerContext->withValue($context, $callback->call($this));
            }
        });
        $this->server->on('request', function (\OpenSwoole\HTTP\Request $request, \OpenSwoole\HTTP\Response $response) {
            $this->process($request, $response);
        });
        $this->server->start();
    }

    public function on(string $event, Closure $callback)
    {
        $this->server->on($event, function () use ($callback) { $callback->call($this); });
        return $this;
    }

    public function register(string $class, ServiceInterface $instance = null): self
    {
        if (!class_exists($class)) {
            throw new TypeError("{$class} not found");
        }
        // Only recreate the class if the users dont pass in their initialized class
        if (!$instance) {
            $instance = new $class();
        }
        if (!($instance instanceof ServiceInterface)) {
            throw new TypeError("{$class} is not ServiceInterface");
        }
        $service                             = new ServiceContainer($class, $instance);
        $this->services[$service->getName()] = $service;
        return $this;
    }

    public function process(\OpenSwoole\HTTP\Request $rawRequest, \OpenSwoole\HTTP\Response $rawResponse)
    {
        $context = new Context([
            'WORKER_CONTEXT'                            => $this->workerContext,
            'SERVICES'                                  => $this->services,
            \OpenSwoole\Http\Request::class             => $rawRequest,
            \OpenSwoole\Http\Response::class            => $rawResponse,
            Constant::CONTENT_TYPE                      => $rawRequest->header[Constant::CONTENT_TYPE] ?? '',
            Constant::GRPC_STATUS                       => Status::UNKNOWN,
            Constant::GRPC_MESSAGE                      => '',
        ]);

        try {
            $this->validateRequest($rawRequest);

            [, $service, $method]        = explode('/', $rawRequest->server['request_uri'] ?? '');
            $service                     = '/' . $service;
            $message                     = $rawRequest->getContent() ? substr($rawRequest->getContent(), 5) : '';
            $request                     = new Request($context, $service, $method, $message);

            $response = $this->handler->handle($request);
        } catch (GRPCException $e) {
            Util::log(\OpenSwoole\Constant::LOG_ERROR, $e->getMessage() . ', error code: ' . $e->getCode() . "\n" . $e->getTraceAsString());
            $output          = '';
            $context         = $context->withValue(Constant::GRPC_STATUS, $e->getCode());
            $context         = $context->withValue(Constant::GRPC_MESSAGE, $e->getMessage());
            $response        = new Response($context, $output);
        }

        $this->send($response);
    }

    public function push(Message $message)
    {
        $context = $message->getContext();
        try {
            if ($context->getValue('content-type') !== 'application/grpc+json') {
                $payload = $message->getMessage()->serializeToString();
            } else {
                $payload = $message->getMessage()->serializeToJsonString();
            }
        } catch (Throwable $e) {
            throw InvokeException::create($e->getMessage(), Status::INTERNAL, $e);
        }

        $payload = pack('CN', 0, strlen($payload)) . $payload;

        $ret = $context->getValue(\OpenSwoole\Http\Response::class)->write($payload);
        if (!$ret) {
            throw new \OpenSwoole\Exception('Client side is disconnected');
        }
        return $ret;
    }

    private function validateRequest(\OpenSwoole\HTTP\Request $request)
    {
        if (!isset($request->header['content-type']) || !isset($request->header['te'])) {
            throw InvokeException::create('illegal GRPC request, missing content-type or te header');
        }

        if ($request->header['content-type'] !== 'application/grpc'
            && $request->header['content-type'] !== 'application/grpc+proto'
            && $request->header['content-type'] !== 'application/grpc+json'
        ) {
            throw InvokeException::create("Content-type not supported: {$request->header['content-type']}", Status::INTERNAL);
        }
    }

    private function send(Response $response)
    {
        $context     = $response->getContext();
        $rawResponse = $context->getValue(\OpenSwoole\Http\Response::class);
        $headers     = [
            'content-type' => $context->getValue('content-type'),
            'trailer'      => 'grpc-status, grpc-message',
        ];

        $trailers = [
            Constant::GRPC_STATUS  => $context->getValue(Constant::GRPC_STATUS),
            Constant::GRPC_MESSAGE => $context->getValue(Constant::GRPC_MESSAGE),
        ];

        $payload = pack('CN', 0, strlen($response->getPayload())) . $response->getPayload();

        try {
            foreach ($headers as $name => $value) {
                $rawResponse->header($name, $value);
            }

            foreach ($trailers as $name => $value) {
                $rawResponse->trailer($name, (string) $value);
            }
            $rawResponse->end($payload);
        } catch (\OpenSwoole\Exception $e) {
            Util::log(\OpenSwoole\Constant::LOG_WARNING, $e->getMessage() . ', error code: ' . $e->getCode() . "\n" . $e->getTraceAsString());
        }
    }
}

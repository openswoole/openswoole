<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Core\Psr;

class MiddlewareStack
{
    private array $middlewares = [];

    public function __construct(...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function add($middleware)
    {
        $stack = clone $this;
        array_unshift($stack->middlewares, $middleware);
        return $stack;
    }

    public function handle($request)
    {
        $middleware = $this->middlewares[0] ?? false;
        return $middleware
            ? $middleware->process(
                $request,
                $this->next($middleware)
            )
            : null;
    }

    private function next($middleware)
    {
        $stack = clone $this;
        array_shift($stack->middlewares);
        return $stack;
    }
}

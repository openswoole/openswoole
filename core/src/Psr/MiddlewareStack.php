<?php
/**
 * This file is part of Open Swoole.
 *
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 * @license  https://github.com/openswoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

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

<?php

function go(callable $coroutine): void
{
    OpenSwoole\Coroutine::go($coroutine);
}

class co
{
    public static function run(callable $callback) {}
}

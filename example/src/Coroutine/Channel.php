<?php

co::run(function () {
    function BatchExecMethodByCo()
    {
        $args = func_get_args();
        $channel = new OpenSwoole\Coroutine\Channel(count($args));

        foreach ($args as $key => $func) {
            go(function () use ($channel, $func, $key) {
                $res = $func();
                $channel->push([$key => $res]);
            });
        }

        $list = [];
        go(function () use (&$list, $args, $channel) {
            foreach ($args as $key => $chan) {
                $list[$key] = $channel->pop();
            }
        });

        co::wait();

        return $list;
    }

    function test($value = '')
    {
        co::sleep(1);
        return "test\n";
    }

    function test2($value = '')
    {
        co::sleep(1);
        return "test2 " . rand(1, 10) . "\n";
    }

    $r = BatchExecMethodByCo("test", "test2", "test");
    var_dump($r);
});

<?php

co::run(function () {
    $cli = new OpenSwoole\Coroutine\Http\Client('127.0.0.1', 80);
    $cli->set(array(
        'http_proxy_host' => "127.0.0.1",
        'http_proxy_port' => 33080,
    ));

    $cli->setHeaders([
        'Host' => "localhost",
        "User-Agent" => 'Chrome/49.0.2587.3',
    ]);
    $cli->get('/');

    echo "Length: " . strlen($cli->getBody()) . ", statusCode=".$cli->getStatusCode()."\n";
    $cli->close();
});

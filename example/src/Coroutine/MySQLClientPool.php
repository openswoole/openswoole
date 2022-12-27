<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSwoole\Core\Coroutine\Client\PDOClientFactory;
use OpenSwoole\Core\Coroutine\Client\PDOConfig;
use OpenSwoole\Core\Coroutine\Pool\ClientPool;

co::run(function () {
    $config = (new PDOConfig());
    $pool   = new ClientPool(PDOClientFactory::class, $config);
    $pool->fill();

    $client         = $pool->get();
    $sql            = 'SELECT version()';
    $result         = $client->query($sql);
    var_dump($result->fetchObject());
    $pool->put($client);
});

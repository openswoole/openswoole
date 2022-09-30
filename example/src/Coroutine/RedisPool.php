<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use \OpenSwoole\Core\Coroutine\Pool\ClientPool;
use \OpenSwoole\Core\Coroutine\Client\RedisClientFactory;
use \OpenSwoole\Core\Coroutine\Client\RedisConfig;

co::run(function () {
    $config = (new RedisConfig())->withDbIndex(8);

    $pool = new ClientPool(RedisClientFactory::class, $config);
    $pool->fill();

    $redisClient = $pool->get();
    $redisClient->set('test', 'test_val');
    $pool->put($redisClient);

    $redisClient = $pool->get();
    var_dump($redisClient->get('test'));
    $pool->put($redisClient);

    $pool->close();
});

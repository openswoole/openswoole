<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSwoole\Core\Coroutine\Client\PostgresClientFactory;
use OpenSwoole\Core\Coroutine\Client\PostgresConfig;
use OpenSwoole\Core\Coroutine\Pool\ClientPool;

co::run(function () {
    $config = (new PostgresConfig());

    $pool = new ClientPool(PostgresClientFactory::class, $config);
    $pool->fill();

    $postgresClient = $pool->get();
    $sql            = 'SELECT * FROM test';
    $result         = $postgresClient->query($sql);
    var_dump($postgresClient->fetchAll($result));
    $pool->put($postgresClient);
});

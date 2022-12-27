<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenSwoole\Core\Coroutine\Client\MysqliClientFactory;
use OpenSwoole\Core\Coroutine\Client\MysqliConfig;
use OpenSwoole\Core\Coroutine\Pool\ClientPool;

co::run(function () {
    $config = (new MysqliConfig())->withPassword('');
    $pool   = new ClientPool(MysqliClientFactory::class, $config);
    $pool->fill();

    $client         = $pool->get();
    $sql            = 'SELECT version()';
    $result         = $client->query($sql);
    var_dump($result->fetch_object());
    $pool->put($client);
});

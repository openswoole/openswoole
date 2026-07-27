<?php

use OpenSwoole\Core\Tests\Env;

class MysqlClientTest extends \PHPUnit\Framework\TestCase
{
    public function testConfig()
    {
        Env::loadFile('.env');

        $HOST_NAME = Env::get("HOST_NAME");
        $MYSQL_PORT = Env::get("MYSQL_PORT");
        $MYSQL_USER_NAME = Env::get("MYSQL_USER_NAME");
        $MYSQL_PASSWORD = Env::get("MYSQL_PASSWORD");
        $MYSQL_DB_NAME = Env::get("MYSQL_DB_NAME");

        $mysqlconfig = new \OpenSwoole\Core\Coroutine\Client\MysqliConfig();
        $mysqlconfig->withHost($HOST_NAME)
            ->withPort($MYSQL_PORT)
            ->withUsername($MYSQL_USER_NAME)
            ->withPassword($MYSQL_PASSWORD)
            ->withDbname($MYSQL_DB_NAME);

        $this->assertEquals($mysqlconfig->getHost(), $HOST_NAME);
        $this->assertEquals($mysqlconfig->getPort(), $MYSQL_PORT);
        $this->assertEquals($mysqlconfig->getUsername(), $MYSQL_USER_NAME);
        $this->assertEquals($mysqlconfig->getPassword(), $MYSQL_PASSWORD);
        $this->assertEquals($mysqlconfig->getDbname(), $MYSQL_DB_NAME);
    }

    public function testConnect()
    {
        Env::loadFile('.env');

        $HOST_NAME = Env::get("HOST_NAME");
        $MYSQL_PORT = Env::get("MYSQL_PORT");
        $MYSQL_USER_NAME = Env::get("MYSQL_USER_NAME");
        $MYSQL_PASSWORD = Env::get("MYSQL_PASSWORD");
        $MYSQL_DB_NAME = Env::get("MYSQL_DB_NAME");

        $mysqlconfig = new \OpenSwoole\Core\Coroutine\Client\MysqliConfig();
        $mysqlconfig->withHost($HOST_NAME)
            ->withPort($MYSQL_PORT)
            ->withUsername($MYSQL_USER_NAME)
            ->withPassword($MYSQL_PASSWORD)
            ->withDbname($MYSQL_DB_NAME);

        $mysqlClient = new \OpenSwoole\Core\Coroutine\Client\MysqliClient($mysqlconfig);
        $mysqlClient->heartbeat();
        self::assertTrue(true);
    }

    public function testReConnect()
    {
        Env::loadFile('.env');

        $HOST_NAME = Env::get("HOST_NAME");
        $MYSQL_PORT = Env::get("MYSQL_PORT");
        $MYSQL_USER_NAME = Env::get("MYSQL_USER_NAME");
        $MYSQL_PASSWORD = Env::get("MYSQL_PASSWORD");
        $MYSQL_DB_NAME = Env::get("MYSQL_DB_NAME");

        $mysqlconfig = new \OpenSwoole\Core\Coroutine\Client\MysqliConfig();
        $mysqlconfig->withHost($HOST_NAME)
            ->withPort($MYSQL_PORT)
            ->withUsername($MYSQL_USER_NAME)
            ->withPassword($MYSQL_PASSWORD)
            ->withDbname($MYSQL_DB_NAME);

        $mysqlClient = new \OpenSwoole\Core\Coroutine\Client\MysqliClient($mysqlconfig);
        $mysqlClient->reconnect();
        self::assertGreaterThan(0, $mysqlClient->getRound());
    }

    public function testFactory()
    {
        Env::loadFile('.env');

        $HOST_NAME = Env::get("HOST_NAME");
        $MYSQL_PORT = Env::get("MYSQL_PORT");
        $MYSQL_USER_NAME = Env::get("MYSQL_USER_NAME");
        $MYSQL_PASSWORD = Env::get("MYSQL_PASSWORD");
        $MYSQL_DB_NAME = Env::get("MYSQL_DB_NAME");

        $mysqlconfig = new \OpenSwoole\Core\Coroutine\Client\MysqliConfig();
        $mysqlconfig->withHost($HOST_NAME)
            ->withPort($MYSQL_PORT)
            ->withUsername($MYSQL_USER_NAME)
            ->withPassword($MYSQL_PASSWORD)
            ->withDbname($MYSQL_DB_NAME);

        $mysqlClient = \OpenSwoole\Core\Coroutine\Client\MysqliClientFactory::make($mysqlconfig);
        $mysqlClient->heartbeat();
        self::assertTrue(true);
    }
}
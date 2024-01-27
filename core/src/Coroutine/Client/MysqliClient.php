<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Client;

use mysqli;

class MysqliClient extends ClientProxy
{
    public const IO_METHOD_REGEX = '/^autocommit|begin_transaction|change_user|close|commit|kill|multi_query|ping|prepare|query|real_connect|real_query|reap_async_query|refresh|release_savepoint|rollback|savepoint|select_db|send_query|set_charset|ssl_set$/i';

    public const IO_ERRORS = [
        2002, // MYSQLND_CR_CONNECTION_ERROR
        2006, // MYSQLND_CR_SERVER_GONE_ERROR
        2013, // MYSQLND_CR_SERVER_LOST
    ];

    /** @var mysqli */
    protected object $__object;

    /** @var string */
    protected $charsetContext;

    /** @var array|null */
    protected $setOptContext;

    /** @var array|null */
    protected $changeUserContext;

    /** @var callable */
    protected $constructor;

    /** @var int */
    protected $round = 0;

    protected $config;

    public function __construct(MysqliConfig $config)
    {
        $this->config = $config;
        $this->makeClient();
        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        for ($n = 3; $n--;) {
            $ret = @$this->__object->{$name}(...$arguments);
            if ($ret === false) {
                /* non-IO method */
                if (!preg_match(static::IO_METHOD_REGEX, $name)) {
                    break;
                }
                /* no more chances or non-IO failures */
                if (!in_array($this->__object->errno, static::IO_ERRORS, true) || ($n === 0)) {
                    throw new MysqliException($this->__object->error, $this->__object->errno);
                }
                $this->reconnect();
                continue;
            }
            if (strcasecmp($name, 'prepare') === 0) {
                $ret = new MysqliStatementProxy($ret, $arguments[0], $this);
            } elseif (strcasecmp($name, 'stmt_init') === 0) {
                $ret = new MysqliStatementProxy($ret, null, $this);
            }
            break;
        }
        /* @noinspection PhpUndefinedVariableInspection */
        return $ret;
    }

    public function getRound(): int
    {
        return $this->round;
    }

    public function reconnect(): void
    {
        $this->makeClient();
        $this->round++;
        /* restore context */
        if ($this->charsetContext) {
            $this->__object->set_charset($this->charsetContext);
        }
        if ($this->setOptContext) {
            foreach ($this->setOptContext as $opt => $val) {
                $this->__object->set_opt($opt, $val);
            }
        }
        if ($this->changeUserContext) {
            $this->__object->change_user(...$this->changeUserContext);
        }
    }

    public function heartbeat(): void
    {
        $this->__object->query('SELECT 1');
    }

    public function options(int $option, $value): bool
    {
        $this->setOptContext[$option] = $value;
        return $this->__object->options($option, $value);
    }

    public function set_opt(int $option, $value): bool
    {
        return $this->options($option, $value);
    }

    public function set_charset(string $charset): bool
    {
        $this->charsetContext = $charset;
        return $this->__object->set_charset($charset);
    }

    public function change_user(string $user, string $password, string $database): bool
    {
        $this->changeUserContext = [$user, $password, $database];
        return $this->__object->change_user($user, $password, $database);
    }

    protected function makeClient()
    {
        $client = new mysqli();
        foreach ($this->config->getOptions() as $option => $value) {
            $client->set_opt($option, $value);
        }
        $client->real_connect(
            $this->config->getHost(),
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->config->getDbname(),
            $this->config->getPort(),
            $this->config->getUnixSocket()
        );
        if ($client->connect_errno) {
            throw new MysqliException($client->connect_error, $client->connect_errno);
        }
        $this->__object = $client;
    }
}

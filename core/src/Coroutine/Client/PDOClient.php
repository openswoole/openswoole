<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Core\Coroutine\Client;

use PDO;
use PDOException;

class PDOClient extends ClientProxy
{
    public const IO_METHOD_REGEX = '/^query|prepare|exec|beginTransaction|commit|rollback$/i';

    public const IO_ERRORS = [
        2002, // MYSQLND_CR_CONNECTION_ERROR
        2006, // MYSQLND_CR_SERVER_GONE_ERROR
        2013, // MYSQLND_CR_SERVER_LOST
    ];

    /** @var PDO */
    protected object $__object;

    /** @var array|null */
    protected $setAttributeContext;

    /** @var int */
    protected $round = 0;

    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
        $this->makeClient();
        $this->__object->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
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
                $errorInfo = $this->__object->errorInfo();
                /* no more chances or non-IO failures */
                if (
                    !in_array($errorInfo[1], static::IO_ERRORS, true)
                    || $n === 0
                    || $this->__object->inTransaction()
                ) {
                    /* '00000' means “no error.”, as specified by ANSI SQL and ODBC. */
                    if (!empty($errorInfo) && $errorInfo[0] !== '00000') {
                        $exception            = new PDOException($errorInfo[2], $errorInfo[1]);
                        $exception->errorInfo = $errorInfo;
                        throw $exception;
                    }
                    /* no error info, just return false */
                    break;
                }
                $this->reconnect();
                continue;
            }
            if ((strcasecmp($name, 'prepare') === 0) || (strcasecmp($name, 'query') === 0)) {
                $ret = new PDOStatementProxy($ret, $this);
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
        if ($this->setAttributeContext) {
            foreach ($this->setAttributeContext as $attribute => $value) {
                $this->__object->setAttribute($attribute, $value);
            }
        }
    }

    public function heartbeat(): void
    {
        $this->__object->query('SELECT 1')->fetch();
    }

    public function setAttribute(int $attribute, $value): bool
    {
        $this->setAttributeContext[$attribute] = $value;
        return $this->__object->setAttribute($attribute, $value);
    }

    public function inTransaction(): bool
    {
        return $this->__object->inTransaction();
    }

    protected function makeClient()
    {
        $client = new PDO(
            "{$this->config->getDriver()}:" .
            (
                $this->config->hasUnixSocket() ?
                "unix_socket={$this->config->getUnixSocket()};" :
                "host={$this->config->getHost()};" . "port={$this->config->getPort()};"
            ) .
            "dbname={$this->config->getDbname()};" .
            "charset={$this->config->getCharset()}",
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->config->getOptions()
        );
        $this->__object = $client;
    }
}

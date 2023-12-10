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
use PDOStatement;

class PDOStatementProxy extends ClientProxy
{
    /** @var PDOStatement */
    protected object $__object;

    /** @var array|null */
    protected $setAttributeContext;

    /** @var array|null */
    protected $setFetchModeContext;

    /** @var array|null */
    protected $bindParamContext;

    /** @var array|null */
    protected $bindColumnContext;

    /** @var array|null */
    protected $bindValueContext;

    /** @var PDO|PDOClient */
    protected $parent;

    /** @var int */
    protected $parentRound;

    public function __construct(PDOStatement $object, PDOClient $parent)
    {
        parent::__construct($object);
        $this->parent      = $parent;
        $this->parentRound = $parent->getRound();
    }

    public function __call(string $name, array $arguments)
    {
        for ($n = 3; $n--;) {
            $ret = @$this->__object->{$name}(...$arguments);
            if ($ret === false) {
                /* no IO */
                if (strtolower($name) !== 'execute') {
                    break;
                }
                /* no more chances or non-IO failures or in transaction */
                if (
                    !in_array($this->__object->errorInfo()[1], $this->parent::IO_ERRORS, true)
                    || $n === 0
                    || $this->parent->inTransaction()
                ) {
                    $errorInfo = $this->__object->errorInfo();

                    /* '00000' means “no error.”, as specified by ANSI SQL and ODBC. */
                    if (!empty($errorInfo) && $errorInfo[0] !== '00000') {
                        if (is_int($errorInfo[1]) && is_string($errorInfo[2])) {
                            $exception = new PDOException($errorInfo[2], $errorInfo[1]);
                        } else {
                            $exception = new PDOException('Unknown database error');
                        }
                        $exception->errorInfo = $errorInfo;
                        throw $exception;
                    }
                    /* no error info, just return false */
                    break;
                }
                if ($this->parent->getRound() === $this->parentRound) {
                    /* if not equal, parent has reconnected */
                    $this->parent->reconnect();
                }
                $parent         = $this->parent->__getObject();
                $this->__object = $parent->prepare($this->__object->queryString);
                if ($this->__object === false) {
                    $errorInfo            = $parent->errorInfo();
                    $exception            = new PDOException($errorInfo[2], $errorInfo[1]);
                    $exception->errorInfo = $errorInfo;
                    throw $exception;
                }
                if ($this->setAttributeContext) {
                    foreach ($this->setAttributeContext as $attribute => $value) {
                        $this->__object->setAttribute($attribute, $value);
                    }
                }
                if ($this->setFetchModeContext) {
                    $this->__object->setFetchMode(...$this->setFetchModeContext);
                }
                if ($this->bindParamContext) {
                    foreach ($this->bindParamContext as $param => $item) {
                        $this->__object->bindParam($param, ...$item);
                    }
                }
                if ($this->bindColumnContext) {
                    foreach ($this->bindColumnContext as $column => $item) {
                        $this->__object->bindColumn($column, ...$item);
                    }
                }
                if ($this->bindValueContext) {
                    foreach ($this->bindValueContext as $value => $item) {
                        $this->__object->bindParam($value, ...$item);
                    }
                }
                continue;
            }
            break;
        }
        /* @noinspection PhpUndefinedVariableInspection */
        return $ret;
    }

    public function setAttribute(int $attribute, $value): bool
    {
        $this->setAttributeContext[$attribute] = $value;
        return $this->__object->setAttribute($attribute, $value);
    }

    public function setFetchMode(int $mode, ...$args): bool
    {
        $this->setFetchModeContext = func_get_args();
        return $this->__object->setFetchMode(...$this->setFetchModeContext);
    }

    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = 0, $driver_options = null): bool
    {
        $this->bindParamContext[$parameter] = [$variable, $data_type, $length, $driver_options];
        return $this->__object->bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }

    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null): bool
    {
        $this->bindColumnContext[$column] = [$param, $type, $maxlen, $driverdata];
        return $this->__object->bindColumn($column, $param, $type, $maxlen, $driverdata);
    }

    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR): bool
    {
        $this->bindValueContext[$parameter] = [$value, $data_type];
        return $this->__object->bindValue($parameter, $value, $data_type);
    }
}

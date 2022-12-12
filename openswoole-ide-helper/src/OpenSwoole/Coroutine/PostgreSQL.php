<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Coroutine;

class PostgreSQL
{
    public $error;

    public $errCode;

    public $resultStatus;

    public $resultDiag;

    public $notices;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param mixed $conninfo [required]
     * @return mixed
     */
    public function connect($conninfo)
    {
    }

    /**
     * @param mixed $query [optional]
     * @return mixed
     */
    public function query($query)
    {
    }

    /**
     * @param mixed $stmtname [required]
     * @param mixed $query [required]
     * @return mixed
     */
    public function prepare($stmtname, $query)
    {
    }

    /**
     * @param mixed $stmtname [required]
     * @param mixed $pv_param_arr [required]
     * @return mixed
     */
    public function execute($stmtname, $pv_param_arr)
    {
    }

    /**
     * @param mixed $result [optional]
     * @param mixed $result_type [optional]
     * @return mixed
     */
    public function fetchAll($result, $result_type)
    {
    }

    /**
     * @param mixed $result [optional]
     * @return mixed
     */
    public function affectedRows($result)
    {
    }

    /**
     * @param mixed $result [optional]
     * @return mixed
     */
    public function numRows($result)
    {
    }

    /**
     * @param mixed $result [optional]
     * @return mixed
     */
    public function fieldCount($result)
    {
    }

    /**
     * @param mixed $table_name [required]
     * @return mixed
     */
    public function metaData($table_name)
    {
    }

    /**
     * @param mixed $string [required]
     * @return mixed
     */
    public function escape($string)
    {
    }

    /**
     * @param mixed $string [required]
     * @return mixed
     */
    public function escapeLiteral($string)
    {
    }

    /**
     * @param mixed $string [required]
     * @return mixed
     */
    public function escapeIdentifier($string)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     * @param mixed $class_name [optional]
     * @param mixed $l [optional]
     * @param mixed $ctor_params [optional]
     * @return mixed
     */
    public function fetchObject($result, $row, $class_name, $l, $ctor_params)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     * @return mixed
     */
    public function fetchAssoc($result, $row)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     * @param mixed $result_type [optional]
     * @return mixed
     */
    public function fetchArray($result, $row, $result_type)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     * @param mixed $result_type [optional]
     * @return mixed
     */
    public function fetchRow($result, $row, $result_type)
    {
    }

    /**
     * @return mixed
     */
    public function reset()
    {
    }

    /**
     * @return mixed
     */
    public function status()
    {
    }
}

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
     */
    public function connect($conninfo)
    {
    }

    /**
     * @param mixed $query [optional]
     */
    public function query($query)
    {
    }

    /**
     * @param mixed $stmtname [required]
     * @param mixed $query [required]
     */
    public function prepare($stmtname, $query)
    {
    }

    /**
     * @param mixed $stmtname [required]
     * @param mixed $pv_param_arr [required]
     */
    public function execute($stmtname, $pv_param_arr)
    {
    }

    /**
     * @param mixed $result [optional]
     * @param mixed $result_type [optional]
     */
    public function fetchAll($result, $result_type)
    {
    }

    /**
     * @param mixed $result [optional]
     */
    public function affectedRows($result)
    {
    }

    /**
     * @param mixed $result [optional]
     */
    public function numRows($result)
    {
    }

    /**
     * @param mixed $result [optional]
     */
    public function fieldCount($result)
    {
    }

    /**
     * @param mixed $table_name [required]
     */
    public function metaData($table_name)
    {
    }

    /**
     * @param mixed $string [required]
     */
    public function escape($string)
    {
    }

    /**
     * @param mixed $string [required]
     */
    public function escapeLiteral($string)
    {
    }

    /**
     * @param mixed $string [required]
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
     */
    public function fetchObject($result, $row, $class_name, $l, $ctor_params)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     */
    public function fetchAssoc($result, $row)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     * @param mixed $result_type [optional]
     */
    public function fetchArray($result, $row, $result_type)
    {
    }

    /**
     * @param mixed $result [required]
     * @param mixed $row [optional]
     * @param mixed $result_type [optional]
     */
    public function fetchRow($result, $row, $result_type)
    {
    }

    public function reset()
    {
    }

    public function status()
    {
    }
}

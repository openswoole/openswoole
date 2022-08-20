<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole\Core\Pool;

use mysqli;

/**
 * @method mysqli|MysqliProxy get()
 * @method void put(mysqli|MysqliProxy $connection)
 */
class MysqliPool extends ConnectionPool
{
    /** @var MysqliConfig */
    protected $config;

    public function __construct(MysqliConfig $config, int $size = self::DEFAULT_SIZE)
    {
        $this->config = $config;
        parent::__construct(function () {
            $mysqli = new mysqli();
            foreach ($this->config->getOptions() as $option => $value) {
                $mysqli->set_opt($option, $value);
            }
            $mysqli->real_connect(
                $this->config->getHost(),
                $this->config->getUsername(),
                $this->config->getPassword(),
                $this->config->getDbname(),
                $this->config->getPort(),
                $this->config->getUnixSocket()
            );
            if ($mysqli->connect_errno) {
                throw new MysqliException($mysqli->connect_error, $mysqli->connect_errno);
            }
            return $mysqli;
        }, $size, MysqliProxy::class);
    }
}

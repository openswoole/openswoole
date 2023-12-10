<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */

namespace OpenSwoole\Core\Coroutine\Client;

class PostgresConfig implements ClientConfigInterface
{
    /** @var string */
    protected $host = '127.0.0.1';

    /** @var int */
    protected $port = 5432;

    /** @var string */
    protected $dbname = 'test';

    /** @var string */
    protected $username = 'postgres';

    /** @var string */
    protected $password = '';

    public function getHost(): string
    {
        return $this->host;
    }

    public function withHost($host): self
    {
        $this->host = $host;
        return $this;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function withPort(int $port): self
    {
        $this->port = $port;
        return $this;
    }

    public function getDbname(): string
    {
        return $this->dbname;
    }

    public function withDbname(string $dbname): self
    {
        $this->dbname = $dbname;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function withUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getConnectionString(): string
    {
        return 'host=' . $this->host .
            ';port=' . $this->port .
            ';dbname=' . $this->dbname .
            ';user=' . $this->username .
            ';password=' . $this->password;
    }
}

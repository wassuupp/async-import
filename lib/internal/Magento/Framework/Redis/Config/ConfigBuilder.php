<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis\Config;

use Magento\Framework\Redis\Config;
use Magento\Framework\Redis\ConfigInterface;

class ConfigBuilder
{
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 6379;
    const DEFAULT_DATABASE = 0;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var int
     */
    private $database;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $persistent;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->host = static::DEFAULT_HOST;
        $this->port = static::DEFAULT_PORT;
        $this->database = static::DEFAULT_DATABASE;
        $this->password = null;
        $this->persistent = '';
        $this->timeout = null;
    }

    /**
     * @return ConfigInterface
     */
    public function build(): ConfigInterface
    {
        return new Config(
            $this->host,
            $this->port,
            $this->password,
            $this->database,
            $this->timeout,
            $this->persistent
        );
    }

    /**
     * @param string $host
     *
     * @return ConfigBuilder
     */
    public function setHost(string $host): ConfigBuilder
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @param int $port
     *
     * @return ConfigBuilder
     */
    public function setPort(int $port): ConfigBuilder
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @param int $database
     *
     * @return ConfigBuilder
     */
    public function setDatabase(int $database): ConfigBuilder
    {
        $this->database = $database;
        return $this;
    }

    /**
     * @param string $password
     *
     * @return ConfigBuilder
     */
    public function setPassword(string $password): ConfigBuilder
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $persistent
     *
     * @return ConfigBuilder
     */
    public function setPersistent(string $persistent): ConfigBuilder
    {
        $this->persistent = $persistent;
        return $this;
    }

    /**
     * @param int $timeout
     *
     * @return ConfigBuilder
     */
    public function setTimeout(int $timeout): ConfigBuilder
    {
        $this->timeout = $timeout;
        return $this;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis;

class Config implements ConfigInterface
{
    /**
     * @var string|null
     */
    private $host;

    /**
     * @var int|null
     */
    private $port;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var int
     */
    private $database;

    /**
     * @var int|null
     */
    private $timeout;

    /**
     * @var string
     */
    private $persistent;

    /**
     * @param string?null $host
     * @param int|null $port
     * @param string|null $password
     * @param int|null $database
     * @param int|null $timeout
     * @param string $persistent
     */
    public function __construct(
        ?string $host,
        ?int $port,
        ?string $password,
        int $database,
        ?int $timeout,
        string $persistent
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->database = $database;
        $this->timeout = $timeout;
        $this->persistent = $persistent;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(): int
    {
        return $this->database;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function getPersistent(): string
    {
        return $this->persistent;
    }
}

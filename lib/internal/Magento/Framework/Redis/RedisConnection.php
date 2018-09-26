<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis;

class RedisConnection implements RedisConnectionInterface
{
    /**
     * @var \Credis_Client
     */
    private $client;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient(): \Credis_Client
    {
        if ($this->client !== null) {
            return $this->client;
        }

        $this->client = new \Credis_Client(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getTimeout(),
            $this->config->getPersistent(),
            $this->config->getDatabase(),
            $this->config->getPassword()
        );

        return $this->client;
    }
}

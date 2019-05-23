<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Redis\Config\ConfigBuilder;

class ConfigProvider implements ConfigProviderInterface
{
    private const CONFIG = 'cache';
    private const CONFIG_TYPE = 'support';
    private const CONFIG_HOST = 'host';
    private const CONFIG_PASSWORD = 'password';
    private const CONFIG_PORT = 'port';
    private const CONFIG_DB = 'db';
    private const CONFIG_TIMEOUT = 'timeout';
    private const CONFIG_PERSISTENT = 'persistent';

    /**
     * @var DeploymentConfig
     */
    private $deploymentConfig;

    /**
     * @var ConfigBuilder
     */
    private $configBuilder;

    /**
     * @param DeploymentConfig $deploymentConfig
     * @param ConfigBuilder $configBuilder
     */
    public function __construct(
        DeploymentConfig $deploymentConfig,
        ConfigBuilder $configBuilder
    ) {
        $this->deploymentConfig = $deploymentConfig;
        $this->configBuilder = $configBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): ConfigInterface
    {
        $this->configBuilder->init();
        $resource = $this->deploymentConfig->getConfigData(static::CONFIG) ?? [];
        $credentials = $resource[static::CONFIG_TYPE] ?? [];

        if (array_key_exists(static::CONFIG_HOST, $credentials)) {
            $this->configBuilder->setHost($credentials[static::CONFIG_HOST]);
        }
        if (array_key_exists(static::CONFIG_PASSWORD, $credentials)) {
            $this->configBuilder->setPassword($credentials[static::CONFIG_PASSWORD]);
        }
        if (array_key_exists(static::CONFIG_PORT, $credentials)) {
            $this->configBuilder->setPort($credentials[static::CONFIG_PORT]);
        }
        if (array_key_exists(static::CONFIG_DB, $credentials)) {
            $this->configBuilder->setDatabase($credentials[static::CONFIG_DB]);
        }
        if (array_key_exists(static::CONFIG_TIMEOUT, $credentials)) {
            $this->configBuilder->setTimeout($credentials[static::CONFIG_TIMEOUT]);
        }
        if (array_key_exists(static::CONFIG_PERSISTENT, $credentials)) {
            $this->configBuilder->setPersistent($credentials[static::CONFIG_PERSISTENT]);
        }

        return $this->configBuilder->build();
    }
}

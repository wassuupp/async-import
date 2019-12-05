<?php

namespace Magento\AsynchronousImportDataExchanging\Model\Configuration;

use Magento\Framework\App\DeploymentConfig;

class Config implements ConfigInterface
{
    /** @var DeploymentConfig */
    private $deploymentConfig;

    /**
     * Config constructor.
     *
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        DeploymentConfig $deploymentConfig
    ) {
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * Loads the configured exchange adapter
     *
     * @return string
     */
    public function getAdapterConfiguration()
    {
        /** @var string $key */
        $key = self::ASYNCHRONOUS_IMPORT_NODE . "/" . self::EXCHANGE_ADAPTER_NODE;

        return $this->deploymentConfig->get(
            $key,
            self::DEFAULT_EXCHANGE_ADAPTER
        );
    }
}

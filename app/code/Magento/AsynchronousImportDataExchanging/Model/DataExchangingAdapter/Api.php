<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\DataExchangingAdapter;

use Magento\AsynchronousImportDataExchangingApi\Api\boolen;
use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\MiddlewareExchangeAdapterInterface;
use Magento\AsynchronousImportDataExchanging\Model\Configuration\ConfigInterface;

/**
 * Data Exchange adapter for Magento API connection
 *
 * @api
 */
class Api implements MiddlewareExchangeAdapterInterface
{
    private $remoteReceiver;

    /**
     * Api constructor.
     * @param array $exchangingProperties
     */
    public function __construct(
        array $exchangingProperties = []
    ) {
        $this->exchangingProperties = $exchangingProperties;
    }

    /**
     * @param $remoteReceiver \Magento\AsynchronousImportDataExchangingApi\Api\Data\RemoteReceiverInterface
     * @return $this
     */
    public function setRemoteReceiver($remoteReceiver)
    {
        return $this->remoteReceiver = $remoteReceiver;
    }

    /**
     * @return array|null
     */
    public function getParameters()
    {
        $data = $this->remoteReceiver->getData();

        if (is_array($data)) {
            return $data;
        }

        return null;
    }

    /**
     * Execute processing
     *
     * @param ImportInterface $import
     * @param array $importData
     */
    public function execute(ImportInterface $import, array $importData): void{

        echo "do Export via API here";
        var_dump($this->exchangingProperties);
        $parameters = $this->getParameters();
        $token = $parameters[ConfigInterface::INTEGRATION_TOKEN];
        $baseUrl = $parameters[ConfigInterface::BASE_URL];
        exit;
    }
}

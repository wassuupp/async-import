<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\DataExchangingAdapter;

use Magento\AsynchronousImportDataExchangingApi\Api\boolen;
use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterWithReceiverInterface;

/**
 * Data Exchange adapter for Magento API connection
 *
 * @api
 */
class Api implements ExchangeAdapterWithReceiverInterface
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
     * Execute processing
     *
     * @param ImportInterface $import
     * @param array $importData
     */
    public function execute(ImportInterface $import, array $importData): void{

        echo "do Export via API here";
        var_dump($this->exchangingProperties);
        $integrationToken = $this->remoteReceiver->getIntegrationToken();
        $baseUrl = $this->remoteReceiver->getBaseUrl();
        exit;

    }


}

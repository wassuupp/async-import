<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model;

use Magento\AsynchronousImportDataExchanging\Exception\AdapterNotFoundException;
use Magento\AsynchronousImportDataExchanging\Model\Configuration\ConfigInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\Data\RemoteReceiverInterfaceFactory;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterWithReceiverInterface;

/**
 * Registry for receive processors of import data
 *
 * @api
 */
class ExchangeAdaptersRegistry
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var RemoteReceiverInterfaceFactory
     */
    private $remoteReceiverFactory;

    /**
     * ExchangeAdaptersRegistry constructor.
     * @param ConfigInterface $config
     * @param RemoteReceiverInterfaceFactory $remoteReceiverFactory
     * @param array $exchangeAdapters
     */
    public function __construct(
        ConfigInterface $config,
        RemoteReceiverInterfaceFactory $remoteReceiverFactory,
        array $exchangeAdapters
    ) {
        $this->config = $config;
        $this->remoteReceiverFactory = $remoteReceiverFactory;
        $this->exchangeAdapters = $exchangeAdapters;
    }

    /**
     * @return \Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterInterface
     * @throws AdapterNotFoundException
     */
    public function get()
    {
        if (!isset($this->exchangeAdapters[$this->config->getAdapterType()])
            || !$this->exchangeAdapters[$this->config->getAdapterType()] instanceof ExchangeAdapterInterface
        ) {
            throw new AdapterNotFoundException(
                __('Exchange Adapter was not found. Check dependency injection configuration.')
            );
        }

        /** @var ExchangeAdapterInterface $adapter */
        $adapter = $this->exchangeAdapters[
            $this->config->getAdapterType()
        ];

        if ($adapter instanceof ExchangeAdapterWithReceiverInterface) {
            /** @var array $receiverConfig */
            $receiverConfig = $this->config->getReceiverDetails();
            /** @var \Magento\AsynchronousImportDataExchangingApi\Api\Data\RemoteReceiverInterface $remoteReceiver */
            $remoteReceiver = $this->remoteReceiverFactory->create();

            $adapter->setRemoteReceiver(
                $remoteReceiver->setIntegrationToken($receiverConfig[ConfigInterface::INTEGRATION_TOKEN])
                    ->setBaseUrl($receiverConfig[ConfigInterface::BASE_URL])
            );
        }

        return $adapter;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model;

use Magento\AsynchronousImportDataExchanging\Model\Configuration\ConfigInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterInterface;
use Magento\AsynchronousImportDataExchanging\Exception\AdapterNotFoundException;

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
     * ExchangeAdaptersRegistry constructor.
     * @param ConfigInterface $config
     * @param array $exchangeAdapters
     */
    public function __construct(
        ConfigInterface $config,
        array $exchangeAdapters
    ) {
        $this->config = $config;
        $this->exchangeAdapters = $exchangeAdapters;
    }

    /**
     * @return \Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterInterface
     * @throws AdapterNotFoundException
     */
    public function get()
    {
        if (!isset($this->exchangeAdapters[$this->config->getAdapterConfiguration()])
            || !$this->exchangeAdapters[$this->config->getAdapterConfiguration()] instanceof ExchangeAdapterInterface
        ) {
            throw new AdapterNotFoundException(
                __('Exchange Adapter was not found. Check dependency injection configuration.')
            );
        }

        /** @var ExchangeAdapterInterface $adapter */
        $adapter = $this->exchangeAdapters[
            $this->config->getAdapterConfiguration()
        ];

        return $adapter;
    }
}

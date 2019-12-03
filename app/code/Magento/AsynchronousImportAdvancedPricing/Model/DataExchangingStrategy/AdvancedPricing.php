<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportAdvancedPricing\Model\DataExchangingStrategy;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Model\ExchangeDataStrategyInterface;

/**
 * @inheritdoc
 */
class AdvancedPricing implements ExchangeDataStrategyInterface
{
    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    public function execute(ImportInterface $import, array $importData): void
    {
    }

    /**
     * @param array $tierPriceData
     * @return TierPriceInterface
     */
    private function getFilledTierPriceModel(array $tierPriceData)
    {
        $tierPrice = $this->tierPriceFactory->create();

        $tierPrice->setPrice($tierPriceData[self::PRICE_KEY_NAME]);
        $tierPrice->setPriceType($tierPriceData[self::VALUE_KEY_NAME]);
        $tierPrice->setWebsiteId($tierPriceData[self::WEBSITE_KEY_NAME]);
        $tierPrice->setSku($tierPriceData[self::SKU_KEY_NAME]);
        $tierPrice->setCustomerGroup($tierPriceData[self::CUSTOMER_GROUP_KEY_NAME]);
        $tierPrice->setQuantity($tierPriceData[self::QTY_KEY_NAME]);

        return $tierPrice;
    }
}

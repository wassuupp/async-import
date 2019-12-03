<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportAdvancedPricing\Model\DataExchangingStrategy;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Model\ExchangeDataStrategyInterface;
use Magento\AsynchronousOperations\Model\MassSchedule;
use Magento\Catalog\Api\Data\TierPriceInterface;
use Magento\Catalog\Api\Data\TierPriceInterfaceFactory;
use Magento\Catalog\Api\TierPriceStorageInterface;
use Magento\Framework\Exception\BulkException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\Webapi\ServiceInputProcessor;

/**
 * @inheritdoc
 */
class AdvancedPricing implements ExchangeDataStrategyInterface
{
    public const BULK_API_TOPIC_NAME = "async.magento.catalog.api.tierpricestorageinterface.import";

    /**
     * @var TierPriceStorageInterface
     */
    private $priceStorage;

    /**
     * @var ServiceInputProcessor
     */
    private $serviceInputProcessor;

    /**
     * @var MassSchedule
     */
    private $massSchedule;

    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var TierPriceInterfaceFactory
     */
    private $tierPriceFactory;

    /**
     * AdvancedPricing constructor.
     * @param TierPriceStorageInterface $priceStorage
     * @param ServiceInputProcessor $inputProcessor
     * @param MassSchedule $massSchedule
     * @param ArrayManager $arrayManager
     * @param TierPriceInterfaceFactory $tierPriceFactory
     */
    public function __construct(
        TierPriceStorageInterface $priceStorage,
        ServiceInputProcessor $inputProcessor,
        MassSchedule $massSchedule,
        ArrayManager $arrayManager,
        TierPriceInterfaceFactory $tierPriceFactory
    ) {
        $this->priceStorage = $priceStorage;
        $this->serviceInputProcessor = $inputProcessor;
        $this->massSchedule = $massSchedule;
        $this->arrayManager = $arrayManager;
        $this->tierPriceFactory = $tierPriceFactory;
    }

    const PRICE_KEY_NAME = 'tier_price';
    const VALUE_KEY_NAME = 'tier_price_value_type';
    const WEBSITE_KEY_NAME = 'tier_price_website';
    const SKU_KEY_NAME = 'sku';
    const CUSTOMER_GROUP_KEY_NAME = 'tier_price_customer_group';
    const QTY_KEY_NAME = 'tier_price_qty';

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    public function execute(ImportInterface $import, array $importData): void
    {
        $requestItems = [];
        $requestItems['prices'] = [];
        foreach ($importData as $importLine) {
            $requestItems['prices'][] = $this->getFilledTierPriceModel($importLine);
        }

        try {
            $this->massSchedule->publishMass(
                self::BULK_API_TOPIC_NAME,
                [0 => $requestItems],
                null,
                0
            );
        } catch (BulkException $e) {
            //todo
        } catch (LocalizedException $e) {
            //todo
        }
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

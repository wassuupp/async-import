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
     * @var array Import Behaviours processors
     */
    private $importBehaviours;

    /**
     * AdvancedPricing constructor.
     *
     * @param array $importBehaviours
     */
    public function __construct(
        array $importBehaviours
    ) {
        $this->importBehaviours = $importBehaviours;
    }

    /**
     * Execution of Advanced pricing import
     *
     * @param ImportInterface $import
     * @param array $importData
     */
    public function execute(ImportInterface $import, array $importData): void
    {
        $this->importBehaviours[$import->getImportBehaviour()]->execute($importData);
    }
}

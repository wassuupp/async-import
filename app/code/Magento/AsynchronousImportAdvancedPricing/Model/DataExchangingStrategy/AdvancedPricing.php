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

    private $importBehaviours;

    public function __construct(
        array $importBehaviours
    ) {
        $this->importBehaviours = $importBehaviours;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    public function execute(ImportInterface $import, array $importData): void
    {
        $this->importBehaviours[$import->getImportBehaviour()]->execute($importData);
    }
}

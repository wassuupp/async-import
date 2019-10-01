<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportAdvancedPricing\Model\ImportDataProcessor;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;

/**
 * @inheritdoc
 */
class AdvancedPricing implements ImportDataProcessorInterface
{
    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    public function execute(ImportInterface $import, array $importData): void
    {
    }
}

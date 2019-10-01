<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Model;

use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportDataExchangeApi\Api\Data\ImportDataInterface;

/**
 * Extension point for adding converting rule applying algorithms
 * Represents concrete strategy
 *
 * @api
 */
interface ApplyConvertingRuleStrategyInterface
{
    /**
     * Converting rule applying strategy
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return ImportDataInterface
     */
    public function execute(
        ImportDataInterface $importData,
        ConvertingRuleInterface $convertingRule
    ): ImportDataInterface;
}

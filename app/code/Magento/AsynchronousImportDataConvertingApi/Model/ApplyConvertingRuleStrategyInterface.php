<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConvertingApi\Model;

use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;

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
     * @param array $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return array
     */
    public function execute(
        array $importData,
        ConvertingRuleInterface $convertingRule
    ): array;
}

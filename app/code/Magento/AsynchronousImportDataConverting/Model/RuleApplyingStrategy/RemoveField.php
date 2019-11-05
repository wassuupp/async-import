<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConverting\Model\RuleApplyingStrategy;

use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportDataConvertingApi\Model\ApplyConvertingRuleStrategyInterface;

/**
 * Take "apply_to" columns and remove it from data
 */
class RemoveField implements ApplyConvertingRuleStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function execute(
        array $importData,
        ConvertingRuleInterface $convertingRule
    ): array {
        $applyTo = $convertingRule->getApplyTo();
        $keysForRemove = array_flip($applyTo);

        foreach ($importData as $key => $row) {
            $importData[$key] = array_diff_key($row, $keysForRemove);
        }
        return $importData;
    }
}

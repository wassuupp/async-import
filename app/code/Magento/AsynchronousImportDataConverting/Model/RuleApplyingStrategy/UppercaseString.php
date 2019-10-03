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
 * Take "apply_to" columns and will make them uppercase
 */
class UppercaseString implements ApplyConvertingRuleStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function execute(
        array $importData,
        ConvertingRuleInterface $convertingRule
    ): array {
        $applyTo = $convertingRule->getApplyTo();

        foreach ($importData as &$row) {
            foreach ($applyTo as $columnName) {
                if (isset($row[$columnName])) {
                    $row[$columnName] = mb_strtoupper($row[$columnName]);
                }
            }
        }
        unset($row);

        return $importData;
    }
}

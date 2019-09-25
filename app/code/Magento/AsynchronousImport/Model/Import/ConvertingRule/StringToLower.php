<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\AsynchronousImport\Model\Import\ConvertingRule;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Model\ConvertingRuleProcessorInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Make a string lowercase
 */
class StringToLower implements ConvertingRuleProcessorInterface
{
    /**
     * Holds rule parameters
     */
    const CONVERTING_RULE_PARAMETER_APPLY_TO = 'apply_to';

    /**
     * Executes converting rule
     *
     * Takes "apply_to" columns and converts values to lower lowercase.
     *
     * @param ImportDataInterface     $importData
     * @param ConvertingRuleInterface $convertingRule
     *
     * @return ImportDataInterface
     * @throws NotFoundException
     */
    public function execute(ImportDataInterface $importData, ConvertingRuleInterface $convertingRule): ImportDataInterface
    {
        $parameters = $convertingRule->getParameters();
        $applyToColumns = $convertingRule->getApplyTo();
        if ([] === $applyToColumns) {
            return $importData;
        }

        $rows = $importData->getData();
        $headers = array_shift($rows) ?? [];
        $applyToHeaders = array_intersect($applyToColumns, $headers);
        if (count($applyToHeaders) < count($applyToColumns)) {
            $phrase = __(
                'The conversting rule "%rule" cannot be applied to these columns: "%columns".',
                [
                    'rule'    => self::CONVERTING_RULE_PARAMETER_APPLY_TO,
                    'columns' => implode(', ', array_diff($applyToColumns, $applyToHeaders)),
                ]
            );
            throw new NotFoundException($phrase);
        }
        foreach ($applyToColumns as $applyToColumn) {
            $key = array_search($applyToColumn, $headers, true);
            foreach ($rows as &$row) {
                $row[$key] = $this->conversionMap[strtolower($row[$key])] ?? $row[$key];
            }
        }
        return $importData->setData(array_merge([$headers], $rows));
    }
}

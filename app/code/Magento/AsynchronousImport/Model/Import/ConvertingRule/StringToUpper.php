<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import\ConvertingRule;

use Magento\AsynchronousImportApi\{
    Api\Data\ConvertingRuleInterface,
    Api\Data\ImportDataInterface,
    Model\ConvertingRuleProcessorInterface};

/**
 * Class StringToUpper
 * @package Magento\AsynchronousImport\Model\Import\ConvertingRule
 */
class StringToUpper implements ConvertingRuleProcessorInterface
{
    /**
     * Execution converting rule
     *
     * Convert values for apply_to columns to uppercase
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return ImportDataInterface
     */
    public function execute(
        ImportDataInterface $importData,
        ConvertingRuleInterface $convertingRule
    ): ImportDataInterface {
        $data = $importData->getData();

        foreach ($convertingRule->getApplyTo() as $applyToField) {
            foreach ($data as &$row) {
                $row[$applyToField] = \mb_strtoupper($row[$applyToField]);
            }
        }
        unset($row);

        $importData->{ImportDataInterface::DATA} = $data;

        return $importData;
    }
}

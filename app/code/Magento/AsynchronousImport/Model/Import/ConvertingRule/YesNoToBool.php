<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import\ConvertingRule;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Model\ConvertingRuleProcessorInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Converts "yes"/"no" to the boolean equivalent
 */
class YesNoToBool implements ConvertingRuleProcessorInterface
{
    /**
     * Holds rule parameters
     */
    const CONVERTING_RULE_PARAMETER_APPLY_TO = 'apply_to';

    /**
     * Holds values to be converted
     */
    const VALUE_YES = 'yes';
    const VALUE_NO = 'no';

    /**
     * Maps values to their boolean equivalents
     *
     * @var array
     */
    private $conversionMap = [
        self::VALUE_YES => 1,
        self::VALUE_NO  => 0,
    ];

    /**
     * Executes converting rule
     *
     * Takes "apply_to" columns and converts values "Yes" or "No" to 0 or 1 respectively.
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return ImportDataInterface
     * @throws NotFoundException
     */
    public function execute(
        ImportDataInterface $importData,
        ConvertingRuleInterface $convertingRule
    ): ImportDataInterface {
        $parameters = $convertingRule->getParameters();

        $applyToColumns = $parameters[self::CONVERTING_RULE_PARAMETER_APPLY_TO] ?? [];
        if ([] === $applyToColumns) {
            return $importData;
        }

        $rows = $importData->getData();
        $headers = array_shift($rows) ?? [];

        $applyToHeaders = array_intersect($applyToColumns, $headers);
        $missings = array_diff($applyToColumns, $applyToHeaders);
        if (count($missings) > 0) {
            $phrase = __(
                'The conversting rule "%rule" cannot be applied to these columns: "%columns".',
                [
                    'rule'    => self::CONVERTING_RULE_PARAMETER_APPLY_TO,
                    'columns' => implode(', ', array_filter($missings)),
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

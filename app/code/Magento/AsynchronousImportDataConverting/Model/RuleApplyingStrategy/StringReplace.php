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
 * Take "applyTo" columns and replace all occurrences of the search string with the replacement string
 */
class StringReplace implements ApplyConvertingRuleStrategyInterface
{
    public const RULE_IDENTIFIER = 'string_replace';

    public const PARAMETER_SEARCH = 'search';
    public const PARAMETER_REPLACE = 'replace';

    /**
     * @inheritdoc
     */
    public function execute(
        array $importData,
        ConvertingRuleInterface $convertingRule
    ): array {
        $applyTo = $convertingRule->getApplyTo();
        $parameters = $convertingRule->getParameters();

        foreach ($importData as &$row) {
            foreach ($applyTo as $columnName) {
                if (isset($row[$columnName])) {
                    $row[$columnName] = str_replace(
                        $parameters[self::PARAMETER_SEARCH],
                        $parameters[self::PARAMETER_REPLACE],
                        $row[$columnName]
                    );
                }
            }
        }
        unset($row);

        return $importData;
    }
}

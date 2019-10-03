<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConvertingApi\Api;

use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;
use Magento\Framework\Validation\ValidationException;

/**
 * Apply converting rules to import data operation. Uses differect strategies for rules applying
 * Responsible for data changing before import
 *
 * @api
 */
interface ApplyConvertingRulesInterface
{
    /**
     * Apply converting rules to import data operation. Uses differect strategies for rules applying
     *
     * @param array $importData
     * @param ConvertingRuleInterface[] $convertingRules
     * @return array
     * @throws ValidationException
     * @throws ApplyConvertingRulesException
     */
    public function execute(
        array $importData,
        array $convertingRules
    ): array;
}

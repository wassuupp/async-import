<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Api;

use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;
use Magento\Framework\Validation\ValidationException;

/**
 * Describes how to change data before import
 * Apply converting rules to import data operation. Uses differect strategies for rules applying
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

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Model;

use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;
use Magento\Framework\Validation\ValidationResult;

/**
 * Extension point for adding converting rule validators
 *
 * @api
 */
interface ConvertingRuleValidatorInterface
{
    /**
     * Validate converting rule
     *
     * @param ConvertingRuleInterface $convertingRule
     * @return ValidationResult
     */
    public function validate(ConvertingRuleInterface $convertingRule): ValidationResult;
}

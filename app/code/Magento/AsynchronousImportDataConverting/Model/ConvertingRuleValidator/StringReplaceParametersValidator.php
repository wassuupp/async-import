<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConverting\Model\ConvertingRuleValidator;

use Magento\AsynchronousImportDataConverting\Model\RuleApplyingStrategy\StringReplace;
use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportDataConvertingApi\Model\ConvertingRuleValidatorInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class StringReplaceParametersValidator implements ConvertingRuleValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(ValidationResultFactory $validationResultFactory)
    {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function validate(ConvertingRuleInterface $convertingRule): ValidationResult
    {
        $errors = [];
        $identifier = (string)$convertingRule->getIdentifier();

        if (StringReplace::RULE_IDENTIFIER === $identifier) {
            $parameters = $convertingRule->getParameters();

            if (empty($parameters[StringReplace::PARAMETER_SEARCH])) {
                $errors[] = __('Parameter "%field" cannot be empty.', ['field' => StringReplace::PARAMETER_SEARCH]);
            }

            if (empty($parameters[StringReplace::PARAMETER_REPLACE])) {
                $errors[] = __('Parameter "%field" cannot be empty.', ['field' => StringReplace::PARAMETER_REPLACE]);
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

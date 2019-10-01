<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRules\Model\ConvertingRuleValidator;

use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportConvertingRulesApi\Model\ConvertingRuleValidatorInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class IdentifierValidator implements ConvertingRuleValidatorInterface
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

        if (empty($identifier)) {
            $errors[] = __('"%field" cannot be empty.', ['field' => ConvertingRuleInterface::IDENTIFIER]);
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

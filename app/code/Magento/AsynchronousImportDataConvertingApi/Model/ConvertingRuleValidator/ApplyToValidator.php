<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConvertingApi\Model\ConvertingRuleValidator;

use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportDataConvertingApi\Model\ConvertingRuleValidatorInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class ApplyToValidator implements ConvertingRuleValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var array
     */
    private $rulesForWhichApplyToIsRequired;

    /**
     * @param ValidationResultFactory $validationResultFactory
     * @param array $rulesForWhichApplyToIsRequired
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        array $rulesForWhichApplyToIsRequired = []
    ) {
        $this->validationResultFactory = $validationResultFactory;
        $this->rulesForWhichApplyToIsRequired = $rulesForWhichApplyToIsRequired;
    }

    /**
     * @inheritdoc
     */
    public function validate(ConvertingRuleInterface $convertingRule): ValidationResult
    {
        $errors = [];
        $identifier = $convertingRule->getIdentifier();
        $applyTo = $convertingRule->getApplyTo();

        if (isset($this->rulesForWhichApplyToIsRequired[$identifier]) && empty($applyTo)) {
            $errors[] = __('"%field" cannot be empty.', ['field' => ConvertingRuleInterface::APPLY_TO]);
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

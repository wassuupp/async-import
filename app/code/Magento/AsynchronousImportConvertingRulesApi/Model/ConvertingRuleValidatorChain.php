<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Model;

use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesException;
use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * Extension point for adding converting rule validators via DI configuration
 *
 * @api
 */
class ConvertingRuleValidatorChain implements ConvertingRuleValidatorInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var ConvertingRuleValidatorInterface[]
     */
    private $validators;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ValidationResultFactory $validationResultFactory
     * @param array $validators
     * @throws ApplyConvertingRulesException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        $this->objectManager = $objectManager;
        $this->validationResultFactory = $validationResultFactory;
        foreach ($validators as $validator) {
            if (!$validator instanceof ConvertingRuleValidatorInterface) {
                throw new ApplyConvertingRulesException(
                    __('Validator must implement ' . ConvertingRuleValidatorInterface::class . '.')
                );
            }
        }
        $this->validators = $validators;
    }

    /**
     * @inheritdoc
     */
    public function validate(ConvertingRuleInterface $convertingRule): ValidationResult
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($convertingRule);

            if (!$validationResult->isValid()) {
                $errors[] = $validationResult->getErrors();
            }
        }
        $errors = count($errors) ? array_merge(...$errors) : [];
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

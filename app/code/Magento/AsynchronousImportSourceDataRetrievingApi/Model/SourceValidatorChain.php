<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrievingApi\Model;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * Extension point for adding source validators via DI configuration
 *
 * @api
 */
class SourceValidatorChain implements SourceValidatorInterface
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
     * @var SourceValidatorInterface[]
     */
    private $validators;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ValidationResultFactory $validationResultFactory
     * @param array $validators
     * @throws SourceDataRetrievingException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        $this->objectManager = $objectManager;
        $this->validationResultFactory = $validationResultFactory;
        foreach ($validators as $validator) {
            if (!$validator instanceof SourceValidatorInterface) {
                throw new SourceDataRetrievingException(
                    __('Validator must implement ' . SourceValidatorInterface::class . '.')
                );
            }
        }
        $this->validators = $validators;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceInterface $source): ValidationResult
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($source);

            if (!$validationResult->isValid()) {
                $errors[] = $validationResult->getErrors();
            }
        }
        $errors = count($errors) ? array_merge(...$errors) : [];
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

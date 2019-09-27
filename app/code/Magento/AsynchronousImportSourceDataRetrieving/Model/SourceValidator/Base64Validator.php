<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model\SourceValidator;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\SourceValidatorInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class Base64Validator implements SourceValidatorInterface
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
    public function validate(SourceInterface $source): ValidationResult
    {
        $errors = [];
        $sourceDefinition = (string)$source->getSourceDefinition();

        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $sourceDefinition)) {
            $errors[] = __('Base64 import data string is invalid.');
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

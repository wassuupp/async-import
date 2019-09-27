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
class SourceTypeValidator implements SourceValidatorInterface
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
        $sourceType = (string)$source->getSourceType();

        if (empty($sourceType)) {
            $errors[] = __('""%1" cannot be empty.', SourceInterface::SOURCE_TYPE);
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

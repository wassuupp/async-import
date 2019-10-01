<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\ImportValidator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Model\ImportValidatorInterface;

/**
 * Check that "import_behaviour" value is valid
 */
class ImportBehaviourValidator implements ImportValidatorInterface
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
    public function validate(ImportInterface $import): ValidationResult
    {
        $value = (string)$import->getImportBehaviour();

        if ('' === trim($value)) {
            $errors[] = __('"%field" cannot be empty.', ['field' => ImportInterface::IMPORT_BEHAVIOUR]);
            // phpcs:ignore Generic.CodeAnalysis.UnconditionalIfStatement,Magento2.CodeAnalysis.EmptyBlock
        } elseif (false) {
            // TODO: check allowed import behaviours
            return $this->validationResultFactory->create(['errors' => []]);
        } else {
            $errors = [];
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

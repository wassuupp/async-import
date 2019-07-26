<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\ImportServiceException;

/**
 * Class ImportServiceValidator
 */
class ImportServiceValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $validators;

    /**
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        array $validators = []
    ) {
        $this->validators = $validators;
    }

    /**
     * Return error messages in array
     *
     * @param SourceCsvInterface $source
     *
     * @return bool
     * @throws ImportServiceException
     */
    public function validate(SourceCsvInterface $source)
    {
        $errors = [];

        /** check for validations from validators */
        foreach ($this->validators as $validator) {
            /** collect errors */
            $errors = array_merge($errors, $validator->validate($source));
        }

        /** throw errros if there is any */
        if (count($errors)) {
            throw new ImportServiceException(
                __('Invalid request: %1', implode(", ", $errors))
            );
        }

        return true;
    }
}

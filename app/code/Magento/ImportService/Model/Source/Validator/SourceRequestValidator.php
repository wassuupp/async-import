<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\ImportServiceException;

/**
 * Class SourceRequestValidator
 */
class SourceRequestValidator implements ValidatorInterface
{
    /**
     * return error messages in array
     *
     * @param SourceCsvInterface $source
     * @throws ImportServiceException
     * @return array
     */
    public function validate(SourceCsvInterface $source)
    {
        $errors = [];

        if (!$source->getSourceType()) {
            $errors[] = __('%1 cannot be empty', SourceCsvInterface::SOURCE_TYPE);
        }

        if (!$source->getImportData()) {
            $errors[] = __('%1 cannot be empty', SourceCsvInterface::IMPORT_DATA);
        }

        return $errors;
    }
}

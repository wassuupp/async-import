<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;

/**
 * Class SourceRequestValidator
 */
class SourceRequestValidator implements ValidatorInterface
{
    /**
     * Return error messages in array
     *
     * @param SourceCsvInterface $source
     *
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

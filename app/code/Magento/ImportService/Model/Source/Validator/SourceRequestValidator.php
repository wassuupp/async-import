<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 * Class SourceRequestValidator
 */
class SourceRequestValidator implements ValidatorInterface
{
    /**
     * Return error messages in array
     *
     * @param SourceBuilderInterface $source
     *
     * @return array
     */
    public function validate(SourceBuilderInterface $source)
    {
        $errors = [];

        if (!$source->getSourceType()) {
            $errors[] = __('%1 cannot be empty', SourceBuilderInterface::SOURCE_TYPE);
        }

        if (!$source->getImportData()) {
            $errors[] = __('%1 cannot be empty', SourceBuilderInterface::IMPORT_DATA);
        }

        return $errors;
    }
}

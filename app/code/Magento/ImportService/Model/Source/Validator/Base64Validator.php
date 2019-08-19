<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 * Class Base64Validator
 */
class Base64Validator implements ValidatorInterface
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

        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $source->getImportData())) {
            $errors[] = __('Base64 import data string is invalid.');
        }

        return $errors;
    }
}

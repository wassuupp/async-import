<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class UuidValidator
 */
class UuidValidator implements ValidatorInterface
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

        if ($source->getUuid() && !Uuid::isValid($source->getUuid())) {
            $errors[] = __('The uuid %1 is not valid.', $source->getUuid());
        }

        return $errors;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class UuidValidator
 */
class UuidValidator implements ValidatorInterface
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

        if ($source->getUuid() && !Uuid::isValid($source->getUuid())) {
            $errors[] = __('The uuid %1 is not valid.', $source->getUuid());
        }

        return $errors;
    }
}

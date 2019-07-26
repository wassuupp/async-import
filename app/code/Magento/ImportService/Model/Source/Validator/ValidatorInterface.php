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
 *  Validator Interface
 */
interface ValidatorInterface
{
    /**
     * Return error messages in array
     *
     * @param SourceCsvInterface $source
     * @throws ImportServiceException
     *
     * @return bool
     */
    public function validate(SourceCsvInterface $source);
}

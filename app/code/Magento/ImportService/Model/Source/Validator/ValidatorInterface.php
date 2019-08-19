<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Validator Interface
 */
interface ValidatorInterface
{
    /**
     * Return error messages in array
     *
     * @param SourceBuilderInterface $source
     * @throws ImportServiceException
     *
     * @return bool
     */
    public function validate(SourceBuilderInterface $source);
}

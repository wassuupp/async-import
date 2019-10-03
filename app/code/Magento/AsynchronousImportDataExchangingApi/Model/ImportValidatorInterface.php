<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangingApi\Model;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\Framework\Validation\ValidationResult;

/**
 * Extension point for adding import request validators
 *
 * @api
 */
interface ImportValidatorInterface
{
    /**
     * Import validation. Extension point for base validation
     *
     * @param ImportInterface $import
     * @return ValidationResult
     */
    public function validate(ImportInterface $import): ValidationResult;
}

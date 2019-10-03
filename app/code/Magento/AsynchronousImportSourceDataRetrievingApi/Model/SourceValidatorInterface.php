<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrievingApi\Model;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\Framework\Validation\ValidationResult;

/**
 * Extension point for adding source validators
 *
 * @api
 */
interface SourceValidatorInterface
{
    /**
     * Validate source
     *
     * @param SourceInterface $source
     * @return ValidationResult
     */
    public function validate(SourceInterface $source): ValidationResult;
}

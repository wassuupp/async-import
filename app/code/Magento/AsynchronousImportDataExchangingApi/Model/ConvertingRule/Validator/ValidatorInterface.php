<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model\ConvertingRule\Validator;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\ImportException;

interface ValidatorInterface
{
    /**
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface[] $convertingRules
     * @return bool
     * @throws ImportException
     */
    public function validate(
        ImportDataInterface $importData,
        array $convertingRules
    ): bool;
}

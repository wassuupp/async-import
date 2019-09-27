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

class ApplyTo implements ValidatorInterface
{
    /**
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return bool
     * @throws ImportException
     */
    public function validate(ImportDataInterface $importData, ConvertingRuleInterface $convertingRule): bool
    {
        $dataToProcess = $importData->getData();
        $rowToProcess = array_shift($dataToProcess);

        $notExistedKeys = [];
        foreach ($convertingRule->getApplyTo() as $applyToKey) {
            if (!isset($rowToProcess[$applyToKey])) {
                $notExistedKeys[] = $applyToKey;
            }
        }

        if (!empty($notExistedKeys)) {
            throw new ImportException(
                __('Following keys are not existed in import data array: %1.', implode(', ', $notExistedKeys))
            );
        }

        return true;
    }
}

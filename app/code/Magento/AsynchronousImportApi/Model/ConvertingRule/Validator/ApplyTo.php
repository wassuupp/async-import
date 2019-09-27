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
     * @param ConvertingRuleInterface[] $convertingRules
     * @return bool
     * @throws ImportException
     */
    public function validate(ImportDataInterface $importData, array $convertingRules): bool
    {
        $dataToProcess = $importData->getData();
        $rowToProcess = array_shift($dataToProcess);

        $notExistedKeys = [];
        foreach ($convertingRules as $convertingRule) {
            foreach ($convertingRule->getApplyTo() as $applyToKey) {
                if (!isset($rowToProcess[$applyToKey])) {
                    $notExistedKeys[$convertingRule->getName()][] = $applyToKey;
                }
            }
        }

        if (!empty($notExistedKeys)) {
            $ruleMessages = [];
            foreach ($notExistedKeys as $ruleName => $notExistedKey) {
                $ruleMessages[] = $ruleName . ': ' . implode(', ', $notExistedKeys);
            }
            throw new ImportException(
                __('Following keys are not existed in import data array: %1.', implode('; ', $ruleMessages))
            );
        }

        return true;
    }
}

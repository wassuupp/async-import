<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model\ConvertingRule;

use Magento\AsynchronousImport\Model\Import\ImportDataFactory;
use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Model\ConvertingRuleProcessorInterface;

class LeaveColumns implements ConvertingRuleProcessorInterface
{
    /**
     * @var ImportDataFactory
     */
    private $importDataFactory;

    /**
     * LeaveColumns constructor.
     * @param ImportDataFactory $importDataFactory
     */
    public function __construct(ImportDataFactory $importDataFactory)
    {
        $this->importDataFactory = $importDataFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(array $importData, ConvertingRuleInterface $convertingRule): array
    {
        $applyToKeys = $convertingRule->getApplyTo();

        if (empty($applyToKeys)) {
            return $importData;
        }

        $processedImportData = [];
        foreach ($applyToKeys as $applyToKey) {
            $newRow[$applyToKey] = $importData[$applyToKey];
        }

        return $processedImportData;
    }
}

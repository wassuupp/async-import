<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model\ConvertingRule;


use Magento\AsynchronousImport\Model\Import\ImportDataFactory;
use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Model\ConvertingRuleProcessorInterface;

/**
 * Class RemoveField
 * @package Magento\AsynchronousImportApi\Model\ConvertingRule
 */
class RemoveField implements ConvertingRuleProcessorInterface
{
    /**
     * @var ImportDataFactory
     */
    private $importDataFactory;

    /**
     * RemoveField constructor.
     * @param ImportDataFactory $importDataFactory
     */
    public function __construct(ImportDataFactory $importDataFactory)
    {
        $this->importDataFactory = $importDataFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(array $importData, ConvertingRuleInterface $convertingRule): array
    {
        $applyToFields = $convertingRule->getApplyTo();

        if (empty($applyToFields)) {
            return $importData;
        }

        foreach ($applyToFields as $applyToField) {
            unset($importData[$applyToField]);
        }

        return $importData;
    }
}

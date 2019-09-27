<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import\ConvertingRule;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterfaceFactory;
use Magento\AsynchronousImportApi\Api\ImportException;
use Magento\AsynchronousImportApi\Model\ConvertingRuleProcessorInterface;

/**
 * Take "apply_to" columns and will make first letter as upper case
 * @package Magento\AsynchronousImport\Model\Import\ConvertingRule
 */
class UcFirst implements ConvertingRuleProcessorInterface
{
    /**
     * Holds rule parameters
     */
    const CONVERTING_RULE_PARAMETER_APPLY_TO = 'apply_to';

    /**
     * @var ImportDataInterfaceFactory
     */
    private $importDataInterfaceFactory;

    /**
     * UcFirst constructor.
     * @param ImportDataInterfaceFactory $importDataInterfaceFactory
     */
    public function __construct(ImportDataInterfaceFactory $importDataInterfaceFactory)
    {
        $this->importDataInterfaceFactory = $importDataInterfaceFactory;
    }

    /**
     * Responsible for converting import data. Represents one converting rule processor
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return ImportDataInterface
     * @throws ImportException
     */
    public function execute(
        ImportDataInterface $importData,
        ConvertingRuleInterface $convertingRule
    ): ImportDataInterface {
        $parameters = $convertingRule->getParameters();
        $applyToColumns = $parameters[self::CONVERTING_RULE_PARAMETER_APPLY_TO] ?? [];
        if ([] === $applyToColumns) {
            return $importData;
        }

        $rows = $importData->getData();
        $headers = array_shift($rows) ?? [];

        $applyToHeaders = array_intersect($applyToColumns, $headers);
        $missedColumns = array_diff($applyToColumns, $applyToHeaders);
        if (count($missedColumns) > 0) {
            $phrase = __(
                'The converting rule "%rule" cannot be applied to these columns: "%columns".',
                [
                    'rule' => self::CONVERTING_RULE_PARAMETER_APPLY_TO,
                    'columns' => implode(', ', array_filter($missedColumns)),
                ]
            );
            throw new ImportException($phrase);
        }

        foreach ($applyToColumns as $applyToColumn) {
            $key = array_search($applyToColumn, $headers, true);
            foreach ($rows as &$row) {
                $row[$key] = ucfirst($row[$key]);
            }
        }

        return $this->importDataInterfaceFactory->create(array_merge([$headers], $rows));
    }
}

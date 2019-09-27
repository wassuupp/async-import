<?php
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import\ConvertingRule;

use Magento\AsynchronousImportApi\{
    Api\Data\ConvertingRuleInterface,
    Api\Data\ImportDataInterface,
    Api\ImportException,
    Model\ConvertingRuleProcessorInterface};

/**
 * Class StringReplaceConvertor
 * @package Magento\AsynchronousImport\Model\Import\ConvertingRule
 */
class StringReplaceConvertor implements ConvertingRuleProcessorInterface
{
    private const PARAMETER_SEARCH = 'search';
    private const PARAMETER_REPLACE = 'replace';

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
        $data = $importData->getData();
        $parameters = $convertingRule->getParameters();

        if (!$this->validateParameters($parameters)) {
            throw new ImportException(__('Invalid parameters provided.'));
        }

        foreach ($convertingRule->getApplyTo() as $applyToField) {
            foreach ($data as &$row) {
                $row[$applyToField] = \str_replace(
                    $parameters[self::PARAMETER_SEARCH],
                    $parameters[self::PARAMETER_REPLACE],
                    $row[$applyToField]
                );
            }
        }
        unset($row);
        $importData->{ImportDataInterface::DATA} = $data;
        return $importData;
    }

    /**
     * @param array $parameters
     * @return bool
     */
    private function validateParameters(array $parameters): bool
    {
        return isset($parameters[self::PARAMETER_SEARCH], self::PARAMETER_REPLACE);
    }
}

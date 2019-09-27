<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\ImportException;
use Magento\AsynchronousImportApi\Model\ConvertingRule\Validator\ApplyTo;
use Magento\AsynchronousImport\Model\Import\ImportDataFactory;
use Magento\Framework\ObjectManagerInterface;

/**
 * Chain of import data convertors. Extension point for new data converting rules
 *
 * @api
 */
class ConvertingRulesProcessorChain implements ConvertingRulesProcessorInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ApplyTo
     */
    private $applyToValidator;

    /**
     * @var array
     */
    private $ruleProcessors;
    /**
     * @var ImportDataFactory
     */
    private $importDataFactory;

    /**
     * @param ImportDataFactory $importDataFactory
     * @param ObjectManagerInterface $objectManager
     * @param ApplyTo $applyToValidator
     * @param array $ruleProcessors
     * @throws ImportException
     */
    public function __construct(
        ImportDataFactory $importDataFactory,
        ObjectManagerInterface $objectManager,
        ApplyTo $applyToValidator,
        array $ruleProcessors = []
    ) {
        $this->objectManager = $objectManager;
        $this->applyToValidator = $applyToValidator;
        foreach ($ruleProcessors as $ruleProcessor) {
            if (false === is_subclass_of($ruleProcessor, ConvertingRuleProcessorInterface::class)) {
                throw new ImportException(
                    __('%1 must implement %2.', [$ruleProcessor, ConvertingRuleProcessorInterface::class])
                );
            }
        }
        $this->ruleProcessors = $ruleProcessors;
        $this->importDataFactory = $importDataFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportDataInterface $importData, array $convertingRules): ImportDataInterface
    {
        $this->applyToValidator->validate($importData, $convertingRules);

        $processedData = [];
        foreach ($importData->getData() as $dataRow) {
            foreach ($convertingRules as $convertingRule) {
                if (!isset($this->ruleProcessors[$convertingRule->getName()])) {
                    throw new ImportException(
                        __('Converting rule %1 is not supported.', $convertingRule->getName())
                    );
                }

                /** @var ConvertingRuleProcessorInterface $convertingRuleProcessor */
                $convertingRuleProcessor = $this->objectManager->get($this->ruleProcessors[$convertingRule->getName()]);
                $dataRow = $convertingRuleProcessor->execute($dataRow, $convertingRule);
            }
            $processedData[] = $dataRow;
        }
        return $this->importDataFactory->create(['data' => $processedData]);
    }
}

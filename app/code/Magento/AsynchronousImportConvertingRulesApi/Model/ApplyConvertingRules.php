<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesException;
use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * Chain of import data convertors. Extension point for new data converting rules
 *
 * @api
 */
class ApplyConvertingRules implements ApplyConvertingRulesInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var array
     */
    private $ruleProcessors;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $ruleProcessors
     * @throws ApplyConvertingRulesException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $ruleProcessors = []
    ) {
        $this->objectManager = $objectManager;
        foreach ($ruleProcessors as $ruleProcessor) {
            if (false === is_subclass_of($ruleProcessor, ApplyConvertingRuleInterface::class)) {
                throw new ApplyConvertingRulesException(
                    __('%1 must implement %2.', [$ruleProcessor, ApplyConvertingRuleInterface::class])
                );
            }
        }
        $this->ruleProcessors = $ruleProcessors;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportDataInterface $importData, array $convertingRules): ImportDataInterface
    {
        foreach ($convertingRules as $convertingRule) {
            if (!isset($this->ruleProcessors[$convertingRule->getName()])) {
                throw new ApplyConvertingRulesException(
                    __('Converting rule %1 is not supported.', $convertingRule->getName())
                );
            }

            /** @var ApplyConvertingRuleInterface $convertingRuleProcessor */
            $convertingRuleProcessor = $this->objectManager->get($this->ruleProcessors[$convertingRule->getName()]);
            $importData = $convertingRuleProcessor->execute($importData, $convertingRule);
        }
        return $importData;
    }
}

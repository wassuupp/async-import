<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRules\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesException;
use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesInterface;
use Magento\AsynchronousImportConvertingRulesApi\Model\ApplyConvertingRuleStrategyInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * @inheritdoc
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
    private $ruleApplyingStrategies;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $ruleApplyingStrategies
     * @throws ApplyConvertingRulesException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $ruleApplyingStrategies = []
    ) {
        $this->objectManager = $objectManager;
        foreach ($ruleApplyingStrategies as $ruleApplyingStrategy) {
            if (false === is_subclass_of($ruleApplyingStrategy, ApplyConvertingRuleStrategyInterface::class)) {
                throw new ApplyConvertingRulesException(
                    __('%1 must implement %2.', [$ruleApplyingStrategy, ApplyConvertingRuleStrategyInterface::class])
                );
            }
        }
        $this->ruleApplyingStrategies = $ruleApplyingStrategies;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportDataInterface $importData, array $convertingRules): ImportDataInterface
    {
        foreach ($convertingRules as $convertingRule) {
            if (!isset($this->ruleApplyingStrategies[$convertingRule->getIdentifier()])) {
                throw new ApplyConvertingRulesException(
                    __('Converting rule "%1" is not supported.', $convertingRule->getIdentifier())
                );
            }

            /** @var ApplyConvertingRuleStrategyInterface $ruleApplyingStrategy */
            $ruleApplyingStrategy = $this->objectManager->get(
                $this->ruleApplyingStrategies[$convertingRule->getIdentifier()]
            );
            $importData = $ruleApplyingStrategy->execute($importData, $convertingRule);
        }
        return $importData;
    }
}

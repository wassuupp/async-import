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
use Magento\AsynchronousImportConvertingRulesApi\Model\ConvertingRuleValidatorInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResultFactory;

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
     * @var ConvertingRuleValidatorInterface
     */
    private $convertingRuleValidator;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var array
     */
    private $ruleApplyingStrategies;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ConvertingRuleValidatorInterface $convertingRuleValidator
     * @param ValidationResultFactory $validationResultFactory
     * @param array $ruleApplyingStrategies
     * @throws ApplyConvertingRulesException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ConvertingRuleValidatorInterface $convertingRuleValidator,
        ValidationResultFactory $validationResultFactory,
        array $ruleApplyingStrategies = []
    ) {
        $this->objectManager = $objectManager;
        $this->convertingRuleValidator = $convertingRuleValidator;
        $this->validationResultFactory = $validationResultFactory;

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
            $validationResult = $this->convertingRuleValidator->validate($convertingRule);
            if (false === $validationResult->isValid()) {
                throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
            }

            $identifier = $convertingRule->getIdentifier();
            if (!isset($this->ruleApplyingStrategies[$identifier])) {
                $validationResult = $this->validationResultFactory->create(
                    [
                        'errors' => [
                            __(
                                'Converting rule "%identifier" is not supported.',
                                ['identifier' => $identifier]
                            ),
                        ],
                    ]
                );
                throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
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

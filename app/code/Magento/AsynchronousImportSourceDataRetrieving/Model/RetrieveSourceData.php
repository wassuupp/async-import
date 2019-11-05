<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterfaceFactory;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\SourceValidatorInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class RetrieveSourceData implements RetrieveSourceDataInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var SourceValidatorInterface
     */
    private $sourceValidator;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var array
     */
    private $retrievingStrategies;

    /**
     * @var SourceDataInterfaceFactory
     */
    private $sourceDataFactory;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param SourceValidatorInterface $sourceValidator
     * @param ValidationResultFactory $validationResultFactory
     * @param SourceDataInterfaceFactory $sourceDataFactory
     * @param array $retrievingStrategies
     * @throws SourceDataRetrievingException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        SourceValidatorInterface $sourceValidator,
        ValidationResultFactory $validationResultFactory,
        SourceDataInterfaceFactory $sourceDataFactory,
        array $retrievingStrategies = []
    ) {
        $this->objectManager = $objectManager;
        $this->sourceValidator = $sourceValidator;
        $this->validationResultFactory = $validationResultFactory;
        $this->sourceDataFactory = $sourceDataFactory;

        foreach ($retrievingStrategies as $retrievingStrategy) {
            if (false === is_subclass_of($retrievingStrategy, RetrieveSourceDataStrategyInterface::class)) {
                throw new SourceDataRetrievingException(
                    __('%1 must implement %2.', [$retrievingStrategy, RetrieveSourceDataStrategyInterface::class])
                );
            }
        }
        $this->retrievingStrategies = $retrievingStrategies;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): SourceDataInterface
    {
        $validationResult = $this->sourceValidator->validate($source);
        if (false === $validationResult->isValid()) {
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }

        $sourceType = $source->getSourceType();
        if (!isset($this->retrievingStrategies[$sourceType])) {
            $validationResult = $this->validationResultFactory->create(
                [
                    'errors' => [
                        __('Source type "%source_type" is not supported.', ['source_type' => $sourceType]),
                    ],
                ]
            );
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }
        /** @var RetrieveSourceDataStrategyInterface $retrievingStrategy */
        $retrievingStrategy = $this->objectManager->get($this->retrievingStrategies[$sourceType]);
        $iterator = $retrievingStrategy->execute($source);

        /** @var SourceDataInterface $sourceData */
        $sourceData = $this->sourceDataFactory->create(
            [
                SourceDataInterface::ITERATOR => $iterator,
            ]
        );
        return $sourceData;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterfaceFactory;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceDataException;
use Magento\AsynchronousImportRetrievingSourceApi\Model\RetrieveSourceDataStrategyInterface;
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
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var array
     */
    private $retrievingStrategies;

    /**
     * @var RetrievingSourceDataResultInterfaceFactory
     */
    private $retrievingResultFactory;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ValidationResultFactory $validationResultFactory
     * @param RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
     * @param array $retrievingStrategies
     * @throws RetrievingSourceDataException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ValidationResultFactory $validationResultFactory,
        RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory,
        array $retrievingStrategies = []
    ) {
        $this->objectManager = $objectManager;
        $this->validationResultFactory = $validationResultFactory;
        $this->retrievingResultFactory = $retrievingResultFactory;
        foreach ($retrievingStrategies as $retrievingStrategy) {
            if (false === is_subclass_of($retrievingStrategy, RetrieveSourceDataStrategyInterface::class)) {
                throw new RetrievingSourceDataException(
                    __('%1 must implement %2.', [$retrievingStrategy, RetrieveSourceDataStrategyInterface::class])
                );
            }
        }
        $this->retrievingStrategies = $retrievingStrategies;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData): RetrievingSourceDataResultInterface
    {
        $sourceType = $sourceData->getSourceType();
        if (empty($sourceType)) {
            $validationResult = $this->validationResultFactory->create(
                ['errors' => [__('"%field" cannot be empty.', ['field' => SourceDataInterface::SOURCE_TYPE])]]
            );
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }

        if (!isset($this->retrievingStrategies[$sourceType])) {
            $validationResult = $this->validationResultFactory->create(
                ['errors' => [__('Source type "%source_type" is not supported.', ['source_type' => $sourceType])]]
            );
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }
        /** @var RetrieveSourceDataStrategyInterface $retrievingStrategy */
        $retrievingStrategy = $this->objectManager->get($this->retrievingStrategies[$sourceType]);

        $file = $retrievingStrategy->execute($sourceData);

        $retrievingStatus = $this->retrievingResultFactory->create([
            RetrievingSourceDataResultInterface::FILE => $file,
        ]);
        return $retrievingStatus;
    }
}

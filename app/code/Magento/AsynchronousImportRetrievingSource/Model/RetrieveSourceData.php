<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\AsynchronousImportRetrievingSourceApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\Framework\ObjectManagerInterface;

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
     * @var array
     */
    private $retrievingStrategies;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $retrievingStrategies
     * @throws RetrievingSourceException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $retrievingStrategies = []
    ) {
        $this->objectManager = $objectManager;
        foreach ($retrievingStrategies as $retrievingStrategy) {
            if (false === is_subclass_of($retrievingStrategy, RetrieveSourceDataStrategyInterface::class)) {
                throw new RetrievingSourceException(
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
        if (!isset($this->retrievingStrategies[$sourceData->getSourceType()])) {
            throw new RetrievingSourceException(
                __('Source type %1 is not supported.', $sourceData->getSourceType())
            );
        }
        /** @var RetrieveSourceDataStrategyInterface $retrievingStrategy */
        $retrievingStrategy = $this->objectManager->get($this->retrievingStrategies[$sourceData->getSourceType()]);

        return $retrievingStrategy->execute($sourceData);
    }
}

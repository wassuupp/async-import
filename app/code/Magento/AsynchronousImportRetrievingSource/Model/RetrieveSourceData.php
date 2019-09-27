<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataStatusInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataStatusInterfaceFactory;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceDataException;
use Magento\AsynchronousImportRetrievingSourceApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\Framework\Exception\LocalizedException;
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
     * @var RetrievingSourceDataStatusInterfaceFactory
     */
    private $retrievingStatusFactory;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param RetrievingSourceDataStatusInterfaceFactory $retrievingStatusFactory
     * @param array $retrievingStrategies
     * @throws RetrievingSourceDataException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        RetrievingSourceDataStatusInterfaceFactory $retrievingStatusFactory,
        array $retrievingStrategies = []
    ) {
        $this->objectManager = $objectManager;
        $this->retrievingStatusFactory = $retrievingStatusFactory;
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
    public function execute(SourceDataInterface $sourceData): RetrievingSourceDataStatusInterface
    {
        if (!isset($this->retrievingStrategies[$sourceData->getSourceType()])) {
            throw new RetrievingSourceDataException(
                __('Source type %1 is not supported.', $sourceData->getSourceType())
            );
        }
        /** @var RetrieveSourceDataStrategyInterface $retrievingStrategy */
        $retrievingStrategy = $this->objectManager->get($this->retrievingStrategies[$sourceData->getSourceType()]);

        try {
            $filepath = $retrievingStrategy->execute($sourceData);

            $retrievingStatus = $this->createStatus(
                RetrievingSourceDataStatusInterface::STATUS_SUCCESS,
                $filepath
            );
        } catch (LocalizedException $e) {
            $retrievingStatus = $this->createStatus(
                RetrievingSourceDataStatusInterface::STATUS_FAILED,
                null,
                [$e->getMessage()]
            );
        }
        return $retrievingStatus;
    }

    /**
     * Create retrieving source data status
     *
     * @param string $status
     * @param string|null $file
     * @param array $errors
     * @return RetrievingSourceDataStatusInterface
     */
    private function createStatus(
        string $status,
        string $file = null,
        array $errors = []
    ): RetrievingSourceDataStatusInterface {
        $data = [
            RetrievingSourceDataStatusInterface::STATUS => $status,
            RetrievingSourceDataStatusInterface::FILE => $file,
            RetrievingSourceDataStatusInterface::ERRORS => $errors,
        ];
        return $this->retrievingStatusFactory->create($data);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataRetrievingStrategy;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterfaceFactory;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;

/**
 * Base64 encoded data strategy for retrieving source data
 */
class Base64EncodedData implements RetrieveSourceDataStrategyInterface
{
    /**
     * @var SourceDataValidatorInterface
     */
    private $sourceDataValidator;

    /**
     * @var RetrievingSourceDataResultInterfaceFactory
     */
    private $retrievingResultFactory;

    /**
     * @param SourceDataValidatorInterface $sourceDataValidator
     * @param RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
     */
    public function __construct(
        SourceDataValidatorInterface $sourceDataValidator,
        RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
    ) {
        $this->sourceDataValidator = $sourceDataValidator;
        $this->retrievingResultFactory = $retrievingResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData): RetrievingSourceDataResultInterface
    {
        $validationResult = $this->sourceDataValidator->validate($sourceData);
        if (!$validationResult->isValid()) {
            return $this->createResult(
                RetrievingSourceDataResultInterface::STATUS_FAILED,
                null,
                $validationResult->getErrors()
            );
        }

        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $content = base64_decode($sourceData->getSourceData());

        return $this->createResult(RetrievingSourceDataResultInterface::STATUS_SUCCESS, $content);
    }

    /**
     * Create retrieving source data result
     *
     * @param string $status
     * @param string|null $file
     * @param array $errors
     * @return RetrievingSourceDataResultInterface
     */
    private function createResult(string $status, ?string $file, array $errors = []): RetrievingSourceDataResultInterface
    {
        $data = [
            RetrievingSourceDataResultInterface::STATUS => $status,
            RetrievingSourceDataResultInterface::FILE => $file,
            RetrievingSourceDataResultInterface::ERRORS => $errors,
        ];
        return $this->retrievingResultFactory->create($data);
    }
}

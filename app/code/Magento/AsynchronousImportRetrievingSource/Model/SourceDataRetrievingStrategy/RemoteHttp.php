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
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;

/**
 * Http strategy for retrieving source data
 */
class RemoteHttp implements RetrieveSourceDataStrategyInterface
{
    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var SourceDataValidatorInterface
     */
    private $sourceDataValidator;

    /**
     * @var RetrievingSourceDataResultInterfaceFactory
     */
    private $retrievingResultFactory;

    /**
     * @param Filesystem $fileSystem
     * @param SourceDataValidatorInterface $sourceDataValidator
     * @param RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
     */
    public function __construct(
        Filesystem $fileSystem,
        SourceDataValidatorInterface $sourceDataValidator,
        RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
    ) {
        $this->fileSystem = $fileSystem;
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

        try {
            /** @var WriteInterface $writeInterface */
            $writeInterface = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);
            /** read content from external link */
            $content = $writeInterface->getDriver()->fileGetContents($sourceData->getSourceData());
        } catch (FileSystemException $e) {
            return $this->createResult(
                RetrievingSourceDataResultInterface::STATUS_FAILED,
                null,
                [$e->getMessage()]
            );
        }

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
    private function createResult(
        string $status,
        ?string $file,
        array $errors = []
    ) {
        $data = [
            RetrievingSourceDataResultInterface::STATUS => $status,
            RetrievingSourceDataResultInterface::FILE => $file,
            RetrievingSourceDataResultInterface::ERRORS => $errors,
        ];
        return $this->retrievingResultFactory->create($data);
    }
}

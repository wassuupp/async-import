<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataUpload\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\AsynchronousImportSourceDataUploadApi\Api\SourceDataUploadException;
use Magento\AsynchronousImportSourceDataUploadApi\Api\SourceDataUploadInterface;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterfaceFactory;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;

class SourceDataUpload implements SourceDataUploadInterface
{
    /** @var DirectoryList */
    private $directoryList;

    /** @var RetrieveSourceDataInterface */
    private $retrieveSourceDataProcessor;

    /** @var SourceDataUploadResultInterfaceFactory */
    private $sourceDataUploadResultFactory;

    /** @var string */
    private $filePath;

    /** @var File */
    private $file;

    /**
     * SourceDataUpload constructor.
     * @param DirectoryList $directoryList
     * @param RetrieveSourceDataInterface $retrieveSourceDataProcessor
     * @param SourceDataUploadResultInterfaceFactory $sourceDataUploadResultFactory
     * @param File $file
     * @param string $filePath
     */
    public function __construct(
        DirectoryList $directoryList,
        RetrieveSourceDataInterface $retrieveSourceDataProcessor,
        SourceDataUploadResultInterfaceFactory $sourceDataUploadResultFactory,
        File $file,
        $filePath = ''
    ) {
        $this->directoryList = $directoryList;
        $this->retrieveSourceDataProcessor = $retrieveSourceDataProcessor;
        $this->sourceDataUploadResultFactory = $sourceDataUploadResultFactory;
        $this->file = $file;
        $this->filePath = $filePath;
    }

    /**
     * @param SourceDataInterface $sourceData
     * @return SourceDataUploadResultInterface
     * @throws RetrievingSourceException
     * @throws SourceDataUploadException
     */
    public function execute(SourceDataInterface $sourceData): SourceDataUploadResultInterface
    {
        /** @var RetrievingSourceDataResultInterface $fileResult */
        $fileResult = $this->retrieveSourceDataProcessor->execute($sourceData);

        try {
            $fullFilePath = $this->getFullFilePath($this->filePath, $sourceData->getSourceData());
        } catch (\Magento\Framework\Exception\FileSystemException $e) {
            throw new SourceDataUploadException(
                __('Error while fetching target file name %1.', $sourceData->getSourceData())
            );
        }

        $fileSaveResult = $this->file->write($fullFilePath, $fileResult->getFile());
        if (!$fileSaveResult) {
            throw new SourceDataUploadException(
                __('Can not save file %1.', $sourceData->getSourceData())
            );
        }

        return $this->sourceDataUploadResultFactory->create(['file' => $fullFilePath]);
    }

    /**
     * @param $filePath
     * @param $sourceFilePath
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function getFullFilePath($filePath, $sourceFilePath)
    {
        $pathParts = pathinfo($sourceFilePath);
        return $this->directoryList->getPath('var') . DS . $filePath . DS . $pathParts['basename'] . $pathParts['extension'];
    }
}

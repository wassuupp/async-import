<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataUpload\Model;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterface;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterfaceFactory;
use Magento\AsynchronousImportSourceDataUploadApi\Api\SourceDataUploadException;
use Magento\AsynchronousImportSourceDataUploadApi\Api\SourceDataUploadInterface;
use Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy\LocalFile\FileResolver;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Validation\ValidationException;

/**
 * @inheritdoc
 */
class SourceDataUpload implements SourceDataUploadInterface
{
    /** @var DirectoryList */
    private $directoryList;

    /** @var RetrieveSourceDataInterface */
    private $retrieveSourceDataProcessor;

    /** @var SourceDataUploadResultInterfaceFactory */
    private $sourceDataUploadResultFactory;

    /** @var FileResolver  */
    private $fileResolver;

    /** @var string */
    private $filePath;

    /** @var File */
    private $file;

    /**
     * SourceDataUpload constructor.
     * @param DirectoryList $directoryList
     * @param RetrieveSourceDataInterface $retrieveSourceDataProcessor
     * @param SourceDataUploadResultInterfaceFactory $sourceDataUploadResultFactory
     * @param FileResolver $fileResolver
     * @param File $file
     */
    public function __construct(
        DirectoryList $directoryList,
        RetrieveSourceDataInterface $retrieveSourceDataProcessor,
        SourceDataUploadResultInterfaceFactory $sourceDataUploadResultFactory,
        FileResolver $fileResolver,
        File $file
    ) {
        $this->directoryList = $directoryList;
        $this->retrieveSourceDataProcessor = $retrieveSourceDataProcessor;
        $this->sourceDataUploadResultFactory = $sourceDataUploadResultFactory;
        $this->fileResolver = $fileResolver;
        $this->file = $file;
    }

    /**
     * @param SourceInterface $sourceData
     * @return SourceDataUploadResultInterface
     * @throws SourceDataUploadException
     * @throws SourceDataRetrievingException
     * @throws ValidationException
     */
    public function execute(SourceInterface $sourceData): SourceDataUploadResultInterface
    {
        /** @var SourceDataInterface $retrievedData */
        $retrievedData = $this->retrieveSourceDataProcessor->execute($sourceData);

        /** @var string $fileName */
        $fileName = $this->getUniqueFileName($sourceData->getSourceDataFormat());

        try {
            /** @var string $fullFilePath */
            $fullFilePath = $this->getPreparedFullFilePath($fileName);
        } catch (\Magento\Framework\Exception\FileSystemException $e) {
            throw new SourceDataUploadException(
                __('Error while fetching target file path for %1.', $fileName)
            );
        }

        $dataForSave = $this->getFileDataFromIterator($retrievedData->getIterator());

        $fileSaveResult = $this->file->write($fullFilePath, $dataForSave);
        if (!$fileSaveResult) {
            throw new SourceDataUploadException(
                __('Can not save file %1.', $fullFilePath)
            );
        }

        return $this->sourceDataUploadResultFactory->create(['file' => $fileName]);
    }

    /**
     * @param \Traversable $iterator
     * @return string
     */
    private function getFileDataFromIterator(\Traversable $iterator)
    {
        $result = [];
        foreach ($iterator as $batch) {
            foreach ($batch as $row) {
                $result[] = $row;
            }
        }
        return implode("\n", $result);
    }

    /**
     * Get file path and create directory if it does not exist
     *
     * @param string $fileName
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function getPreparedFullFilePath($fileName)
    {
        return $this->fileResolver->getRootPath() . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param $dataFormat
     * @return string
     */
    protected function getUniqueFileName($dataFormat)
    {
        return uniqid() . '.' . $dataFormat;
    }
}

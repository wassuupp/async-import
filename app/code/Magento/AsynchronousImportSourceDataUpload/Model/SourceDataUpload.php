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
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Validation\ValidationException;

/**
 * Class SourceDataUpload
 * @package Magento\AsynchronousImportSourceDataUpload\Model
 */
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
            $fullFilePath = $this->getPreparedFullFilePath($this->filePath, $fileName);
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
     * @param $filePath
     * @param string $fileName
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function getPreparedFullFilePath($filePath, $fileName)
    {
        $directoryPath = $this->directoryList->getPath('var') . DIRECTORY_SEPARATOR . $filePath;
        if (!$this->file->isWriteable($directoryPath)) {
            $this->file->mkdir($directoryPath);
        }

        return $directoryPath . DIRECTORY_SEPARATOR . $fileName;
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

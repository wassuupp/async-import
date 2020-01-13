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
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterface;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterfaceFactory;
use Magento\AsynchronousImportSourceDataUploadApi\Api\SourceDataUploadException;
use Magento\AsynchronousImportSourceDataUploadApi\Api\SourceDataUploadInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;

/**
 * Class SourceDataUpload
 * @package Magento\AsynchronousImportSourceDataUpload\Model
 */
class SourceDataUpload implements SourceDataUploadInterface
{
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var RetrieveSourceDataInterface
     */
    private $retrieveSourceDataProcessor;

    /**
     * @var SourceDataUploadResultInterfaceFactory
     */
    private $sourceDataUploadResultFactory;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $dataSeparator;

    /**
     * SourceDataUpload constructor.
     *
     * @param DirectoryList $directoryList
     * @param RetrieveSourceDataInterface $retrieveSourceDataProcessor
     * @param SourceDataUploadResultInterfaceFactory $sourceDataUploadResultFactory
     * @param File $file
     * @param string x$filePath
     * @oaram string $dataSeparator
     */
    public function __construct(
        DirectoryList $directoryList,
        RetrieveSourceDataInterface $retrieveSourceDataProcessor,
        SourceDataUploadResultInterfaceFactory $sourceDataUploadResultFactory,
        File $file,
        $filePath = '',
        $dataSeparator = SourceInterface::SOURCE_DATA_SEPARATOR
    ) {
        $this->directoryList = $directoryList;
        $this->retrieveSourceDataProcessor = $retrieveSourceDataProcessor;
        $this->sourceDataUploadResultFactory = $sourceDataUploadResultFactory;
        $this->file = $file;
        $this->filePath = $filePath;
        $this->dataSeparator = $dataSeparator;
    }

    /**
     * @inheritdoc
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
     * Get source data for file content
     *
     * @param \Traversable $iterator
     *
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
        return implode(SourceInterface::SOURCE_DATA_SEPARATOR, $result);
    }

    /**
     * Get file path and create directory if it does not exist
     *
     * @param string $filePath
     * @param string $fileName
     *
     * @return string string
     *
     * @throws \Exception
     */
    protected function getPreparedFullFilePath($filePath, $fileName)
    {
        $directoryPath = $this->directoryList->getPath(DirectoryList::VAR_DIR) . DIRECTORY_SEPARATOR . $filePath;
        $this->file->checkAndCreateFolder($directoryPath);
        return $directoryPath . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Get Unique file name for imported data
     *
     * @param string $dataFormat
     *
     * @return string
     */
    protected function getUniqueFileName($dataFormat)
    {
        return uniqid() . '.' . $dataFormat;
    }
}

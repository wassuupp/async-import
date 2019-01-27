<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem\Io\File;
use Magento\ImportService\Exception as ImportServiceException;
use Magento\ImportService\Helper\FileSystem;

/**
 * CSV files processor for asynchronous import
 */
class ExternalFileProcessor implements SourceProcessorInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $fileSystemIo;

    /**
     * @var \Magento\ImportService\Helper\FileSystem
     */
    protected $fileSystemHelper;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param File $fileSystemIo
     * @param FileSystem $fileSystemHelper
     */
    public function __construct(
        File $fileSystemIo,
        FileSystem $fileSystemHelper
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystemHelper = $fileSystemHelper;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(\Magento\ImportService\Api\Data\SourceInterface $source, \Magento\ImportService\Api\Data\SourceUploadResponseInterface $response)
    {
        /** @var string $fileName */
        $fileName = uniqid();

        /** @var string $copyFileFullPath*/
        $copyFileFullPath =  $this->fileSystemHelper->getWorkingDir()
            . $fileName
            . '.'
            . $source->getSourceType();

        if (!$this->fileSystemIo->cp($source->getImportData(), $copyFileFullPath)) {
            /** @var array $lastError */
            $lastError = error_get_last();

            /** @var string $errorMessage */
            $errorMessage = isset($lastError['message']) ? $lastError['message'] : '';

            throw new ImportServiceException(
                __('Cannot copy the remote file: %1', $errorMessage)
            );
        }

        /** Update source's import data */
        $source->setImportData($fileName);

        return $response->setSource($source)->setStatus($response::STATUS_UPLOADED);
    }
}

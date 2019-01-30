<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * CSV files processor for asynchronous import
 */
class ExternalFileProcessor implements SourceProcessorInterface
{
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $fileSystem;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param FileSystem $fileSystem
     */
    public function __construct(
        FileSystem $fileSystem
    ) {
        $this->fileSystem = $fileSystem;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(\Magento\ImportService\Api\Data\SourceInterface $source, \Magento\ImportService\Api\Data\SourceUploadResponseInterface $response)
    {
        /** @var string $workingDirectory */
        $workingDirectory = 'importservice/';

        /** @var string $fileName */
        $fileName = uniqid();

        /** @var \Magento\Framework\Filesystem\Directory\WriteInterface $writeInterface */
        $writeInterface = $this->fileSystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        /** If the directory is not present, it will be created */
        $writeInterface->create($workingDirectory);

        /** @var string $copyFileFullPath*/
        $copyFileFullPath =  $writeInterface->getAbsolutePath($workingDirectory)
            . $fileName
            . '.'
            . $source->getSourceType();

        /** @var \Magento\Framework\Filesystem\Driver\File $driver */
        $driver = $writeInterface->getDriver();

        /** Attempt a copy, may throw \Magento\Framework\Exception\FileSystemException */
        $driver->copy($source->getImportData(), $copyFileFullPath);

        /** Update source's import data */
        $source->setImportData($fileName);

        return $response->setSource($source)->setStatus($response::STATUS_UPLOADED);
    }
}

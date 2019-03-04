<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem\Io\File;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * CSV files processor for asynchronous import
 */
class LocalPathFileProcessor extends AbstractSourceProcessor
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'local_path';

    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param SourceTypePool $sourceTypePool
     */
    public function __construct(
        File $fileSystemIo,
        Filesystem $fileSystem,
        SourceTypePool $sourceTypePool
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        parent::__construct($sourceTypePool);
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        /** @var \Magento\Framework\Filesystem\Directory\Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteSourcePath = $write->getAbsolutePath($source->getImportData());

        /** read content from system */
        $content = $this->fileSystemIo->read($absoluteSourcePath);

        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return parent::processUpload($source, $response);
    }
}

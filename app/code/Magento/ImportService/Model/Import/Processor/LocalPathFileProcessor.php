<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Write;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\Model\Source\Validator\ValidatorInterface;

/**
 * Files processor for asynchronous import
 */
class LocalPathFileProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    public const IMPORT_TYPE = 'local_path';

    /**
     * @var PersistentSourceProcessor
     */
    private $persistentUploader;

    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param PersistentSourceProcessor $persistentUploader
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param ValidatorInterface $validator
     */
    public function __construct(
        PersistentSourceProcessor $persistentUploader,
        File $fileSystemIo,
        Filesystem $fileSystem,
        ValidatorInterface $validator
    ) {
        $this->persistentUploader = $persistentUploader;
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        $this->validator = $validator;
    }

    /**
     *  {@inheritdoc}
     *
     * @throws FileSystemException
     * @throws ValidatorException
     */
    public function processUpload(
        SourceBuilderInterface $source,
        SourceUploadResponseInterface $response
    ): SourceUploadResponseInterface {
        $this->validator->validate($source);
        /** @var Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);
        /** create absolute path */
        $absoluteSourcePath = $write->getAbsolutePath($source->getImportData());
        /** read content from system */
        $content = $this->fileSystemIo->read($absoluteSourcePath);
        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return $this->persistentUploader->processUpload($source, $response);
    }
}

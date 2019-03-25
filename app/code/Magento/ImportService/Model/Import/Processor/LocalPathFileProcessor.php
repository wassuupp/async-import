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
use Magento\ImportService\Model\Source\Validator\ValidatorInterface;
use Magento\ImportService\ImportServiceException;

/**
 * CSV files processor for asynchronous import
 */
class LocalPathFileProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'local_path';

    /**
     * @var PersistentSourceProcessor
     */
    private $persistantUploader;

    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var array
     */
    private $validators;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param PersistentSourceProcessor $persistantUploader
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        PersistentSourceProcessor $persistantUploader,
        File $fileSystemIo,
        Filesystem $fileSystem,
        $validators = []
    ) {
        $this->persistantUploader = $persistantUploader;
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        $this->validators = $validators;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        $errors = [];

        /** check for validations from validators */
        foreach($this->validators as $validator) {
            /** collect errors */
            $errors = array_merge($errors, $validator->validate($source));
        }

        /** throw errros if there is any */
        if(count($errors))
        {
            throw new ImportServiceException(
                __('Invalid request: %1', implode(", ", $errors))
            );
        }

        /** @var \Magento\Framework\Filesystem\Directory\Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteSourcePath = $write->getAbsolutePath($source->getImportData());

        /** read content from system */
        $content = $this->fileSystemIo->read($absoluteSourcePath);

        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return $this->persistantUploader->processUpload($source, $response);
    }
}

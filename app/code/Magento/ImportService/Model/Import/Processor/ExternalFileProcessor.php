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
use Magento\ImportService\Model\Source\Validator;
use Magento\ImportService\ImportServiceException;

/**
 * CSV files processor for asynchronous import
 */
class ExternalFileProcessor extends AbstractSourceProcessor
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'external';

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $fileSystem;

    /**
     * @var \Magento\ImportService\Model\Source\Validator
     */
    private $validator;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param Filesystem $fileSystem
     * @param Validator $validator
     * @param SourceTypePool $sourceTypePool
     */
    public function __construct(
        Filesystem $fileSystem,
        Validator $validator,
        SourceTypePool $sourceTypePool
    ) {
        $this->fileSystem = $fileSystem;
        $this->validator = $validator;
        parent::__construct($sourceTypePool);
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(\Magento\ImportService\Api\Data\SourceInterface $source, \Magento\ImportService\Api\Data\SourceUploadResponseInterface $response)
    {
        /** Validate the $source object */
        if ($errors = $this->validator->validateRequest($source)) {
            throw new ImportServiceException(
                __('Invalid request: %1', implode(", ", $errors))
            );
        }

        /** Check if the domain exists and the file within that domain exists */
        if (!$this->validator->checkIfRemoteFileExists($source->getImportData())) {
            throw new ImportServiceException(
                __('Remote file %1 does not exist.', $source->getImportData())
            );
        }

        /** Validate the remote file content type */
        if (!$this->validator->validateMimeTypeForRemoteFile($source->getImportData())) {
            throw new ImportServiceException(
                __('Invalid mime type, expected is one of: %1', implode(", ", $this->validator->getAllowedMimeTypes()))
            );
        }

        /** @var \Magento\Framework\Filesystem\Directory\WriteInterface $writeInterface */
        $writeInterface = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** read content from external link */
        $content = $writeInterface->getDriver()->fileGetContents($source->getImportData());

        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return parent::processUpload($source, $response);
    }
}

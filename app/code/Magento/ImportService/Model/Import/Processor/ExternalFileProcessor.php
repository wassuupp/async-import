<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\ImportService\Exception as ImportServiceException;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportService\Model\Source\Validator;

/**
 * CSV files processor for asynchronous import
 */
class ExternalFileProcessor implements SourceProcessorInterface
{
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
     * @param FileSystem $fileSystem
     * @param Validator $validator
     */
    public function __construct(
        FileSystem $fileSystem,
        Validator $validator
    ) {
        $this->fileSystem = $fileSystem;
        $this->validator = $validator;
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

        /** @var string $workingDirectory */
        $workingDirectory = SourceProcessorPool::WORKING_DIR;

        /** @var string $fileName */
        $fileName =  uniqid() . '.' . $source->getSourceType();

        /** @var \Magento\Framework\Filesystem\Directory\WriteInterface $writeInterface */
        $writeInterface = $this->fileSystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        /** If the directory is not present, it will be created */
        $writeInterface->create($workingDirectory);

        /** @var string $copyFileFullPath*/
        $copyFileFullPath =  $writeInterface->getAbsolutePath($workingDirectory) . $fileName;

        /** Attempt a copy, may throw \Magento\Framework\Exception\FileSystemException */
        $writeInterface->getDriver()->copy($source->getImportData(), $copyFileFullPath);

        return $response->setSource($source->setImportData($fileName))
            ->setStatus($response::STATUS_UPLOADED);
    }
}

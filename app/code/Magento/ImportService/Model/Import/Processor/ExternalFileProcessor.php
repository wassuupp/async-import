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
    protected $fileSystem;

    /**
     * @var \Magento\ImportService\Model\Source\Validator
     */
    protected $validator;

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
        /** Validate the $source */
        if ($errors = $this->validator->validateRequest($source)) {
            throw new ImportServiceException(
                __('Invalid request: %1', implode(", ", $errors))
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

        /** Validate the copied file mime type */
        if (!$this->validator->validateMimeType($copyFileFullPath)) {
            $writeInterface->delete($copyFileFullPath);

            throw new ImportServiceException(
                __('Invalid mime type, expected is one of: %1', implode(", ", $this->validator::EXPECTED_MIME_TYPES))
            );
        }

        return $response->setSource($source->setImportData($fileName))
            ->setStatus($response::STATUS_UPLOADED);
    }
}

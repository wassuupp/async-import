<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\Model\Source\Validator\ValidatorInterface;

/**
 * CSV files processor for asynchronous import
 */
class ExternalFileProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    public const IMPORT_TYPE = 'external';

    /**
     * @var PersistentSourceProcessor
     */
    private $persistentUploader;

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
     * @param Filesystem $fileSystem
     * @param ValidatorInterface $validator
     */
    public function __construct(
        PersistentSourceProcessor $persistentUploader,
        Filesystem $fileSystem,
        ValidatorInterface $validator
    ) {
        $this->persistentUploader = $persistentUploader;
        $this->fileSystem = $fileSystem;
        $this->validator = $validator;
    }

    /**
     *  {@inheritdoc}
     *
     * @throws FileSystemException
     */
    public function processUpload(
        SourceCsvInterface $source,
        SourceUploadResponseInterface $response
    ): SourceUploadResponseInterface {

        $this->validator->validate($source);
        /** @var WriteInterface $writeInterface */
        $writeInterface = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);
        /** read content from external link */
        $content = $writeInterface->getDriver()->fileGetContents($source->getImportData());
        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return $this->persistentUploader->processUpload($source, $response);
    }
}

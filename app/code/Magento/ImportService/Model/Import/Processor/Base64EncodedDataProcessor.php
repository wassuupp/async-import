<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportService\Exception as ImportServiceException;

/**
 * Base64 encoded data processor for asynchronous import
 */
class Base64EncodedDataProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'base64_encoded_data';

    /**
     * CSV Source Type
     */
    const SOURCE_TYPE_CSV = 'csv';

    /**
     * The destination directory
     */
    const DIR_IMPORT_DESTINATION = 'import/';

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * LocalPathFileProcessor constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(\Magento\ImportService\Api\Data\SourceInterface $source, \Magento\ImportService\Api\Data\SourceUploadResponseInterface $response)
    {
        /** @var string $fileName */
        $fileName = rand();

        /** @var string $contentFilePath */
        $contentFilePath =  self::DIR_IMPORT_DESTINATION
            . $fileName
            . '.'
            . $source->getSourceType();

        /** @var string $content */
        $content = base64_decode($source->getImportData());

        /** @var Magento\Framework\Filesystem\Directory\Write $var */
        $var = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        if(!$var->writeFile($contentFilePath, $content))
        {
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

        return $response->setSource($source)->setSourceId($fileName)->setStatus($response::STATUS_UPLOADED);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\Framework\File\Mime\Proxy as Mime;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * Class LocalFileValidator
 */
class LocalFileValidator implements ValidatorInterface
{
    /**
     * @var Mime
     */
    private $mime;

    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var SourceTypePool
     */
    private $sourceTypePool;

    /**
     * @param Mime $mime
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param SourceTypePool $sourceTypePool
     */
    public function __construct(
        Mime $mime,
        File $fileSystemIo,
        Filesystem $fileSystem,
        SourceTypePool $sourceTypePool
    ) {
        $this->mime = $mime;
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        $this->sourceTypePool = $sourceTypePool;
    }

    /**
     * return error messages in array
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return []
     */
    public function validate(SourceInterface $source)
    {
        $errors = [];

        /** @var \Magento\Framework\Filesystem\Directory\Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteFilePath = $write->getAbsolutePath($source->getImportData());

        /** check if file exist */
        if(!$this->fileSystemIo->fileExists($absoluteFilePath)) {
            $errors[] = __('Local file %1 does not exist.', $source->getImportData());
        }
        else {
            /** @var string $mimeType */
            $mimeType = $this->mime->getMimeType($absoluteFilePath);

            if (!in_array($mimeType, $this->sourceTypePool->getAllowedMimeTypes())) {
                $errors[] = __('Invalid mime type, expected is one of: %1', implode(", ", $this->sourceTypePool->getAllowedMimeTypes()));
            }
        }

        return $errors;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Filesystem\Directory\Write;
use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class LocalPathValidator
 */
class LocalPathValidator implements ValidatorInterface
{
    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     */
    public function __construct(
        File $fileSystemIo,
        Filesystem $fileSystem
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Return error messages in array
     *
     * @param SourceCsvInterface $source
     *
     * @return array
     * @throws FileSystemException
     * @throws ValidatorException
     */
    public function validate(SourceCsvInterface $source)
    {
        $errors = [];

        /** @var Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteFilePath = $write->getAbsolutePath($source->getImportData());

        /** check if file exist */
        if (!$this->fileSystemIo->fileExists($absoluteFilePath)) {
            $errors[] = __('Local file %1 does not exist.', $source->getImportData());
        }

        return $errors;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy\LocalFile;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Resolves file storage data.
 * Used in the local file strategy for retrieving source data.
 */
class FileResolver
{
    const DIR_PERMISSIONS = "0775";

    private $directoryList;

    private $file;

    private $relativePath;

    public function __construct(
        DirectoryList $directoryList,
        File $file,
        $relativePath = ""
    ) {
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->relativePath = $relativePath;
    }

    /**
     * Returns absolute path for persisting files.
     * If the path does not exist, try to create directories.
     *
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getRootPath(): string
    {
        $rootPath = $this->directoryList->getPath('var') . DIRECTORY_SEPARATOR .$this->relativePath;
        if (!$this->file->isExists($rootPath)) {
            $this->file->createDirectory($rootPath);
        }
        return $rootPath;
    }

    /**
     * Check if requested file is available
     *
     * @param string $filePath
     * @return bool
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function isFileAvailable(string $filePath): bool
    {
        if ($this->file->isFile($filePath) && $this->file->isReadable($filePath)) {
            return true;
        }
        return false;
    }

    /**
     * Returns file contents
     *
     * @param string $filePath
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getFileContents(string $filePath): string
    {
        return $this->file->fileGetContents($filePath);
    }
}

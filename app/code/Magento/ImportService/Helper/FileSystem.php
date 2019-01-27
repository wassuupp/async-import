<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\ImportService\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem as FrameworkFileSystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * ImportService file system helper
 */
class FileSystem extends AbstractHelper
{
    /**
     * Working Directory
     */
    const WORKING_DIR = 'importexport/';

    /**
     * Temporary Directory
     */
    const TEMPORARY_DIR = 'tmp_importexport/';

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $varDirectory;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * Construct
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        Context $context,
        FrameworkFileSystem $filesystem
    ) {
        $this->varDirectory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);

        if (!is_dir($this->getWorkingDir())) {
            mkdir($this->getWorkingDir(), 0775, true);
        }

        parent::__construct($context);
    }

    /**
     * Get path to working directory
     * @return string 
     */
    public function getWorkingDir() {
        return $this->varDirectory->getAbsolutePath(self::WORKING_DIR);
    }

    /**
     * Get path to temporary directory
     * @return string 
     */
    public function getTemporaryDir() {
        return $this->mediaDirectory->getAbsolutePath(self::TEMPORARY_DIR);
    }
}
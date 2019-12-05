<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataUpload\Model;

use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterface;

/**
 * Class SourceDataUploadResult
 * @package Magento\AsynchronousImportSourceDataUpload\Model
 */
class SourceDataUploadResult implements SourceDataUploadResultInterface
{
    /** @var string */
    private $file;

    /**
     * SourceDataUploadResult constructor.
     * @param string $file
     */
    public function __construct(string $file = '')
    {
        $this->file = $file;
    }

    /**
     * @inheritDoc
     */
    public function getFile(): string
    {
        return $this->file;
    }
}

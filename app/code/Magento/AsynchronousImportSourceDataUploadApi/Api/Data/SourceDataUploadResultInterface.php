<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataUploadApi\Api\Data;

/**
 * Path of uploaded file
 *
 * @api
 */
interface SourceDataUploadResultInterface
{
    const FILE = 'file';

    /**
     * Get path
     *
     * @return string
     */
    public function getFile(): string;
}

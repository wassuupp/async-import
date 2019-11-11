<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataUploadApi\Api;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;

interface SourceDataUploadInterface
{
    /**
     * @param SourceInterface $sourceData
     * @return SourceDataUploadResultInterface
     * @throws SourceDataRetrievingException
     * @throws SourceDataUploadException
     */
    public function execute(SourceInterface $sourceData): SourceDataUploadResultInterface;
}

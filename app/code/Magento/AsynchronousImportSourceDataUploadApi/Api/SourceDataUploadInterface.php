<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\AsynchronousImportSourceDataUploadApi\API\SourceDataUploadException;

declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataUploadApi\Api;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportSourceDataUploadApi\Api\Data\SourceDataUploadResultInterface;

interface SourceDataUploadInterface
{
    /**
     * @param SourceDataInterface $sourceData
     * @return SourceDataUploadResultInterface
     * @throws RetrievingSourceException
     * @throws SourceDataUploadException
     */
    public function execute(SourceDataInterface $sourceData): SourceDataUploadResultInterface;
}

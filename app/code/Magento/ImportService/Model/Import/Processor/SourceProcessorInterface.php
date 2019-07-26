<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Request processor interface
 */
interface SourceProcessorInterface
{
    /**
     * @param SourceCsvInterface $source
     * @param SourceUploadResponseInterface $response
     * @throws ImportServiceException
     *
     * @return SourceUploadResponseInterface
     */
    public function processUpload(
        SourceCsvInterface $source,
        SourceUploadResponseInterface $response
    ): SourceUploadResponseInterface;
}

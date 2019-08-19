<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Request processor interface
 */
interface SourceProcessorInterface
{
    /**
     * @param SourceBuilderInterface $source
     * @param SourceUploadResponseInterface $response
     * @throws ImportServiceException
     *
     * @return SourceUploadResponseInterface
     */
    public function processUpload(
        SourceBuilderInterface $source,
        SourceUploadResponseInterface $response
    ): SourceUploadResponseInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrievingApi\Api;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterface;
use Magento\Framework\Validation\ValidationException;

/**
 * Retrieve source data operation. Uses differect strategies for source data retrieving
 *
 * @api
 */
interface RetrieveSourceDataInterface
{
    /**
     * Retrieve source data operation. Uses differect strategies for source data retrieving
     *
     * @param SourceInterface $source
     * @return SourceDataInterface
     * @throws ValidationException
     * @throws SourceDataRetrievingException
     */
    public function execute(SourceInterface $source): SourceDataInterface;
}

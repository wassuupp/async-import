<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;

/**
 * Extension point for adding of new data source retrieving algorithm
 * Represents concrete strategy
 *
 * @api
 */
interface RetrieveSourceDataStrategyInterface
{
    /**
     * Retrieve source data operation
     *
     * @param SourceDataInterface $sourceData
     * @return RetrievingSourceDataResultInterface
     * @throws RetrievingSourceException
     */
    public function execute(SourceDataInterface $sourceData): RetrievingSourceDataResultInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceDataException;
use Magento\Framework\Validation\ValidationException;

/**
 * Extension point for adding of new data source retrieving algorithms
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
     * @return string Local file path
     * @throws ValidationException
     * @throws RetrievingSourceDataException
     */
    public function execute(SourceDataInterface $sourceData): string;
}

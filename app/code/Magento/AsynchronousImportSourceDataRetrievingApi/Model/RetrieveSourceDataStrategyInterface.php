<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrievingApi\Model;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;

/**
 * Extension point for adding new source data retrieving algorithms
 * Represents concrete strategy
 *
 * @api
 */
interface RetrieveSourceDataStrategyInterface
{
    /**
     * Source data retrieving strategy
     *
     * @param SourceInterface $source
     * @return \Traversable
     * @throws SourceDataRetrievingException
     */
    public function execute(SourceInterface $source): \Traversable;
}

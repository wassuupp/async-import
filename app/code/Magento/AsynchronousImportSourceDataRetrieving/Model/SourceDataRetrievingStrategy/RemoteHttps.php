<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\RetrieveSourceDataStrategyInterface;

/**
 * Https strategy for retrieving source data
 */
class RemoteHttps implements RetrieveSourceDataStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): \Traversable
    {
        return new \ArrayIterator(['remote-https-data']);
    }
}

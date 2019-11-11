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
 * Base64 encoded data strategy for retrieving source data
 */
class Base64EncodedData implements RetrieveSourceDataStrategyInterface
{
    /**
     * @var int
     */
    private $batchSize = 3;

    /**
     * @var string
     */
    private $dataSeparator;

    /**
     * @param string $dataSeparator
     */
    public function __construct(
        $dataSeparator
    ) {
        $this->dataSeparator = $dataSeparator;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): \Traversable
    {
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $data = base64_decode($source->getSourceDefinition());
        $data = explode($this->dataSeparator, $data);

        return new \ArrayIterator($data);
    }
}

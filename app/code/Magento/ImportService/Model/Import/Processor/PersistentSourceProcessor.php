<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * Define the source type pool and process the request
 */
class PersistentSourceProcessor implements SourceProcessorInterface
{
    /**
     * @var SourceTypePool
     */
    private $sourceTypePool;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @param SourceTypePool $sourceTypePool
     * @param DateTime $dateTime
     */
    public function __construct(
        SourceTypePool $sourceTypePool,
        DateTime $dateTime
    ) {
        $this->sourceTypePool = $sourceTypePool;
        $this->dateTime = $dateTime;
    }

    /**
     * {@inheritdoc}
     *
     * @return SourceUploadResponseInterface
     * @throws ImportServiceException
     */
    public function processUpload(
        SourceCsvInterface $source,
        SourceUploadResponseInterface $response
    ): SourceUploadResponseInterface {
        $sourceType = $this->sourceTypePool->getSourceType($source);
        /** save processed content get updated source object */
        $source->setCreatedAt(strftime('%Y-%m-%d %H:%M:%S', $this->dateTime->gmtTimestamp()));
        $source = $sourceType->save($source);

        /** return response with details */
        return $response->setUuid($source->getUuid())->setStatus($source->getStatus());
    }
}

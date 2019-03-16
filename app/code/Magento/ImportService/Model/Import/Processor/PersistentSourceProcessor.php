<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\ImportService\ImportServiceException;

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
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * @param SourceTypePool $sourceTypePool
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     */
    public function __construct(
        SourceTypePool $sourceTypePool,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->sourceTypePool = $sourceTypePool;
        $this->dateTime = $dateTime;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ImportServiceException
     * @return SourceTypeInterface
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        /** @var \Magento\ImportService\Model\Import\Type\SourceTypeInterface $sourceType */
        $sourceType = $this->sourceTypePool->getSourceType($source);

        /** save processed content get updated source object */
        $source = $sourceType->save($source);
        $source->setCreatedAt(strftime('%Y-%m-%d %H:%M:%S', $this->dateTime->gmtTimestamp()));

        /** return response with details */
        return $response->setSource($source)->setSourceId($source->getSourceId())->setStatus($source->getStatus());
    }
}

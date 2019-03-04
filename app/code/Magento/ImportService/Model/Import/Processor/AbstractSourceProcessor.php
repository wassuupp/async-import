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

/**
 * Define the source type pool and process the request
 */
abstract class AbstractSourceProcessor implements SourceProcessorInterface
{
    /**
     * @var SourceTypePool
     */
    protected $sourceTypePool;

    /**
     * @param SourceTypePool $sourceTypePool
     */
    public function __construct(
        SourceTypePool $sourceTypePool
    ) {
        $this->sourceTypePool = $sourceTypePool;
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

        /** return response with details */
        return $response->setSource($source)->setSourceId($source->getSourceId())->setStatus($source->getStatus());
    }
}

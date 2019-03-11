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
     * @var string
     */
    private $content;

    /**
     * @param SourceTypePool $sourceTypePool
     */
    public function __construct(
        SourceTypePool $sourceTypePool
    ) {
        $this->sourceTypePool = $sourceTypePool;
    }

    /**
     * Set processed content to save the source request
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ImportServiceException
     * @return SourceTypeInterface
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        if(is_null($this->content))
        {
            /** Throw error when content is null */
            throw new ImportServiceException(
                __('Invalid content, unable to upload source data.')
            );
        }

        /** @var \Magento\ImportService\Model\Import\Type\SourceTypeInterface $sourceType */
        $sourceType = $this->sourceTypePool->getSourceType($source);

        /** save processed content get updated source object */
        $source = $sourceType->save($source, $this->content);

        /** return response with details */
        return $response->setSource($source)->setSourceId($source->getSourceId())->setStatus($source->getStatus());
    }
}

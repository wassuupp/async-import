<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportService\Api\SourceCsvUploadInterface;

/**
 * Class SourceUpload
 */
class SourceCsvUpload implements SourceCsvUploadInterface
{

    /**
     * const SOURCE_TYPE
     */
    const SOURCE_TYPE = "csv";

    /**
     * @var SourceProcessorPool
     */
    protected $sourceProcessorPool;

    /**
     * @var SourceUploadResponse
     */
    protected $responseFactory;

    /**
     * @param SourceUploadResponseFactory $responseFactory
     * @param SourceProcessorPool $sourceProcessorPool
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceProcessorPool $sourceProcessorPool
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param SourceCsvInterface $source
     * @return SourceUploadResponseFactory
     */
    public function execute(SourceCsvInterface $source)
    {
        try {
            $source->setSourceType(self::SOURCE_TYPE);
            $processor = $this->sourceProcessorPool->getProcessor($source);
            $response = $this->responseFactory->create();
            $processor->processUpload($source, $response);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }
        return $response;
    }
}

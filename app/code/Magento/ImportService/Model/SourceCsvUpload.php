<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportServiceApi\Api\SourceCsvUploadInterface;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportServiceApi\Model\SourceUploadResponseFactory;
use Magento\ImportServiceApi\Api\Data\SourceInterfaceFactory as SourceInterfaceFactory;

/**
 * Class SourceCsvUpload
 */
class SourceCsvUpload implements SourceCsvUploadInterface
{

    /**
     * @var SourceProcessorPool
     */
    private $sourceProcessorPool;

    /**
     * @var SourceUploadResponse
     */
    private $responseFactory;

    /**
     * @param SourceUploadResponseFactory $responseFactory
     * @param SourceProcessorPool $sourceProcessorPool
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceProcessorPool $sourceProcessorPool,
        SourceInterfaceFactory $sourceInterfaceFactory
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->responseFactory = $responseFactory;
        $this->sourceInterfaceFactory = $sourceInterfaceFactory;
    }

    /**
     * @param SourceCsvInterface $source
     *
     * @return SourceUploadResponse
     */
    public function execute(SourceCsvInterface $source): SourceUploadResponseInterface
    {
        try {
            $source->setSourceType(SourceCsvInterface::CSV_SOURCE_TYPE);
            $processor = $this->sourceProcessorPool->getProcessor($source);
            $response = $this->responseFactory->create();

            $sourceFactory = $this->sourceInterfaceFactory->create();

            $source->getFormat();

            $sourceFactory->setData($source->getData());
            $sourceFactory->setFormat($source->getFormat()->toArray());

            $processor->processUpload($sourceFactory, $response);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }

        return $response;
    }
}

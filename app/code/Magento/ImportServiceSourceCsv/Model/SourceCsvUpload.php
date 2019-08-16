<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model;

use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportServiceSourceCsvApi\Api\SourceCsvUploadInterface;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportServiceApi\Model\SourceUploadResponseFactory;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface;

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
     * @var SourceBuilderInterface
     */
    private $sourceBuilder;

    /**
     * SourceCsvUpload constructor.
     * @param SourceUploadResponseFactory $responseFactory
     * @param SourceProcessorPool $sourceProcessorPool
     * @param SourceBuilderInterface $sourceBuilder
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceProcessorPool $sourceProcessorPool,
        SourceBuilderInterface $sourceBuilder
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->responseFactory = $responseFactory;
        $this->sourceBuilder = $sourceBuilder;
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

            $this->sourceBuilder
                ->setData($source->getData());

            if ($source->getFormat()){
                $this->sourceBuilder->setFormat($source->getFormat()->toArray());
            }else{
                $format = [
                    SourceCsvFormatInterface::CSV_SEPARATOR => SourceCsvFormatInterface::DEFAULT_CSV_SEPARATOR,
                    SourceCsvFormatInterface::CSV_ENCLOSURE => SourceCsvFormatInterface::DEFAULT_CSV_ENCLOSURE,
                    SourceCsvFormatInterface::CSV_DELIMITER => SourceCsvFormatInterface::DEFAULT_CSV_DELIMITER,
                    SourceCsvFormatInterface::MULTIPLE_VALUE_SEPARATOR => SourceCsvFormatInterface::DEFAULT_MULTIPLE_VALUE_SEPARATOR
                ];
                $this->sourceBuilder->setFormat($format);
            }

            $processor = $this->sourceProcessorPool->getProcessor($this->sourceBuilder);
            $response = $this->responseFactory->create();

            $processor->processUpload($this->sourceBuilder, $response);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }

        return $response;
    }
}

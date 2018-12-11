<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceDataInterface;
use Magento\ImportService\Model\ImportResponseFactory as ImportResponse;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportService\Api\ImportInterface;

/**
 * Class Import
 *
 * @package Magento\ImportService\Model
 */
class Import implements ImportInterface
{

    /**
     * @var SourceProcessorPool
     */
    protected $sourceProcessorPool;

    /**
     * @var ImportResponse
     */
    protected $response;

    /**
     * Import constructor.
     * @param ImportResponseFactory $response
     * @param SourceProcessorPool $sourceProcessorPool
     */
    public function __construct(
        ImportResponse $response,
        SourceProcessorPool $sourceProcessorPool
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->response = $response;
    }

    /**
     * @param SourceDataInterface $sourceData
     * @return ImportResponseFactory
     */
    public function import(SourceDataInterface $sourceData){

        $response = $this->response->create();
        try {
            $processor = $this->sourceProcessorPool->getProcessor($sourceData);
            $processor->processUpload($sourceData);

            $response->setSourceId($sourceData->getSourceId());
            $response->setStatus($sourceData->getStatus());
        } catch (\Exception $e) {
            $this->response->setFailed()->setError($e->getMessage());
        }
        return $response;

    }

}

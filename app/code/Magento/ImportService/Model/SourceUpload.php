<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportService\Api\SourceUploadInterface;
use Magento\ImportService\Model\Source\Validator;
use Magento\ImportService\ImportServiceException;

/**
 * Class SourceUpload
 */
class SourceUpload implements SourceUploadInterface
{

    /**
     * @var SourceProcessorPool
     */
    protected $sourceProcessorPool;

    /**
     * @var SourceUploadResponse
     */
    protected $responseFactory;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param SourceUploadResponseFactory $responseFactory
     * @param SourceProcessorPool $sourceProcessorPool
     * @param Validator $validator
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceProcessorPool $sourceProcessorPool,
        Validator $validator
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->responseFactory = $responseFactory;
        $this->validator = $validator;
    }

    /**
     * @param SourceInterface $source
     * @return SourceUploadResponseFactory
     */
    public function execute(SourceInterface $source)
    {
        try {
            if ($source->getUuid() && !$this->validator->validateUuid($source)) {
                throw new ImportServiceException(
                    __('The uuid %1 is not valid.', $source->getUuid())
                );
            }

            $processor = $this->sourceProcessorPool->getProcessor($source);
            $response = $this->responseFactory->create();
            $processor->processUpload($source, $response);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }
        return $response;
    }
}

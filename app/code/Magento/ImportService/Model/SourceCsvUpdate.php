<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\SourceCsvUpdateInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\ImportServiceException;

/**
 * Class SourceCsvUpdate
 */
class SourceCsvUpdate implements SourceCsvUpdateInterface
{
    /**
     * @var SourceUploadResponseFactory
     */
    protected $responseFactory;

    /**
     * @var SourceRepositoryInterface
     */
    protected $sourceRepository;

    /**
     * @param SourceUploadResponseFactory $responseFactory,
     * @param SourceRepositoryInterface $sourceRepository
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceRepositoryInterface $sourceRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Update source.
     *
     * @param string $uuid
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return SourceUploadResponseFactory
     */
    public function execute(string $uuid, SourceInterface $source)
    {
        $response = $this->responseFactory->create();

        try {
            $object = $this->sourceRepository->getByUuid($uuid);
            if($object->getId()) {
                if($object->getSourceType() != "csv") {
                    throw new ImportServiceException(
                        __('Specified Source type "%1" is wrong.', 'csv')
                    );
                }
                $object->setFormat($source->getFormat());
                $this->sourceRepository->save($object);
                $source = $this->sourceRepository->getByUuid($uuid);
                $response->setSource($source)->setUuid($source->getUuid())->setStatus($source->getStatus());

            } else {
                throw new ImportServiceException(
                    __('Specified uuid "%1" does not exist.', $uuid)
                );
            }

        } catch (ImportServiceException $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }

        return $response;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\Api\SourceCsvUpdateInterface;
use Magento\ImportService\Api\SourceCsvRepositoryInterface;
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
     * @var SourceCsvRepositoryInterface
     */
    protected $sourceRepository;

    /**
     * @param SourceUploadResponseFactory $responseFactory,
     * @param SourceCsvRepositoryInterface $sourceRepository
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceCsvRepositoryInterface $sourceRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Update source.
     *
     * @param string $uuid
     * @param \Magento\ImportService\Api\Data\SourceCsvInterface $source
     * @return SourceUploadResponseFactory
     */
    public function execute(string $uuid, SourceCsvInterface $source)
    {
        $response = $this->responseFactory->create();

        try {
            $sourceToUpdate = $this->sourceRepository->getByUuid($uuid);
            if($sourceToUpdate->getId()) {
                if($sourceToUpdate->getSourceType() != SourceCsvInterface::CSV_SOURCE_TYPE) {
                    throw new ImportServiceException(
                        __('Specified Source type "%1" is wrong.', SourceCsvInterface::CSV_SOURCE_TYPE)
                    );
                }
                $sourceToUpdate->setFormat($source->getFormat());
                $this->sourceRepository->save($sourceToUpdate);
                $source = $this->sourceRepository->getByUuid($uuid);
                $response->setUuid($source->getUuid())->setStatus($source->getStatus());

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

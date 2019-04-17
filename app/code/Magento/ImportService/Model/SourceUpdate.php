<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\SourceUpdateInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Api\Data\SourceUpdateResponseInterface;

/**
 * Class SourceUpdate
 */
class SourceUpdate implements SourceUpdateInterface
{
    /**
     * @var SourceUpdateResponse
     */
    protected $responseFactory;

    /**
     * @var SourceRepositoryInterface
     */
    protected $sourceRepository;

    /**
     * @param SourceUpdateResponseFactory $responseFactory,
     * @param SourceRepositoryInterface $sourceRepository
     */
    public function __construct(
        SourceUpdateResponseFactory $responseFactory,
        SourceRepositoryInterface $sourceRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Update source.
     *
     * @param string $sourceType
     * @param string $uuid
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return \Magento\ImportService\Api\Data\SourceUpdateResponseInterface
     */
    public function execute(string $sourceType, string $uuid, SourceInterface $source)
    {
        $response = $this->responseFactory->create();

        try {
            $object = $this->sourceRepository->getByUuid($uuid);
            if($object->getId()) {
                if($object->getSourceType() != $sourceType) {
                    throw new ImportServiceException(
                        __('Specified Source type "%1" is wrong.', $sourceType)
                    );
                }
                $object->setFormat($source->getFormat());
                $this->sourceRepository->save($object);
            } else {
                throw new ImportServiceException(
                    __('Specified uuid "%1" does not exist.', $uuid)
                );
            }
            $response->setStatus(SourceUpdateResponseInterface::STATUS_SUCCESS)->setMessage((string)__('Source updated successfully with provided parameters.'));
        } catch (ImportServiceException $e) {
            $response->setStatus(SourceUpdateResponseInterface::STATUS_FAILED)->setMessage($e->getMessage());
        }

        return $response;
    }
}

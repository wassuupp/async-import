<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface;
use Magento\ImportServiceApi\Api\ImportStatusInterface;

/**
 * Class Import
 *
 * @package Magento\ImportService\Model
 */
class ImportStatus implements ImportStatusInterface
{
    /**
     * Import response factory instance
     *
     * @var ImportStatusResponse
     */
    private $responseFactory;

    /**
     * Import response item factory instance
     *
     * @var ImportStatusResponseItem
     */
    private $responseItemFactory;

    /**
     * Status constructor.
     *
     * @param ImportStatusResponseFactory $responseFactory
     * @param ImportStatusResponseItemFactory $responseItemFactory
     */
    public function __construct(
        ImportStatusResponseFactory $responseFactory,
        ImportStatusResponseItemFactory $responseItemFactory
    ) {
        $this->responseFactory = $responseFactory;
        $this->responseItemFactory = $responseItemFactory;
    }

    /**
     * Get import source status.
     *
     * @param string $uuid
     *
     * @return ImportStatusResponse
     */
    public function execute(string $uuid): ImportStatusResponseInterface
    {
        $response = $this->responseFactory->create();
        try {
            $response->setStatus(ImportStatusResponseInterface::STATUS_COMPLETED)
                ->setUuid($uuid)
                ->setEntityType('catalog_product')
                ->setUserId(null)
                ->setUserType(null);

            $item = $this->responseItemFactory->create();
            $item->setUuid($uuid)
                ->setStatus('')
                ->setSerializedData('')
                ->setResultSerializedData('')
                ->setErrorCode('')
                ->setResultMessage('');

            $response->setItems([$item]);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }

        return $response;
    }
}

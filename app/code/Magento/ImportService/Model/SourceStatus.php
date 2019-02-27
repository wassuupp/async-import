<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\SourceStatusInterface;
use Magento\ImportService\Api\Data\SourceStatusResponseInterface;
use Magento\ImportService\Model\SourceStatusResponseItemFactory;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Catalog\Model\Product;

/**
 * Class Import
 *
 * @package Magento\ImportService\Model
 */
class SourceStatus implements SourceStatusInterface
{
	/**
     * @var SourceStatusResponse
     */
    private $responseFactory;

    /**
     * @var SourceStatusResponseItem
     */
    private $responseItemFactory;

    /**
     * @var UserContextInterface
     */
    private $userContext;

    /**
     * Status constructor.
     * @param SourceStatusResponseFactory $responseFactory
     * @param SourceStatusResponseItemFactory $responseItemFactory
     * @param UserContextInterface $userContext
     */
    public function __construct(
        SourceStatusResponseFactory $responseFactory,
        SourceStatusResponseItemFactory $responseItemFactory,
        UserContextInterface $userContext
    ) {
        $this->responseFactory = $responseFactory;
        $this->responseItemFactory = $responseItemFactory;
        $this->userContext = $userContext;
    }

    /**
     * @param string $uuid
     * @return SourceStatusResponseFactory
     */
    public function execute(string $uuid)
    {
        // Create new response object
        $response = $this->responseFactory->create();

        try
        {
            // Set the required response parameters with appropriate details
            $response->setStatus(SourceStatusResponseInterface::STATUS_COMPLETED)
                ->setUuid($uuid)
                ->setEntityType(Product::ENTITY)
                ->setUserId($this->userContext->getUserId())
                ->setUserType($this->userContext->getUserType());

            // Create sample response item object
            $item = $this->responseItemFactory->create();
            $item->setUuid($uuid)
                ->setStatus("")
                ->setSerializedData("")
                ->setResultSerializedData("")
                ->setErrorCode("")
                ->setResultMessage("");

            // Add sample response item object to response
            $response->addItem($item);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }

        return $response;
    }
}

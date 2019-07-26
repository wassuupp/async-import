<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\ObjectManagerInterface;
use Magento\ImportService\Api\Data\ImportStatusResponseInterface;

/**
 * Factory class for \Magento\ImportService\Model\ImportStatusResponse
 */
class ImportStatusResponseFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        $instanceName = '\\Magento\\ImportService\\Model\\ImportStatusResponse'
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     *
     * @return ImportStatusResponse
     */
    public function create(array $data = []): ImportStatusResponse
    {
        return $this->objectManager->create($this->instanceName, $data);
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $error
     *
     * @return ImportStatusResponse
     */
    public function createFailure(string $error = ''): ImportStatusResponse
    {
        $response = $this->objectManager->create($this->instanceName);
        $response->setError($error);
        $response->setStatus(ImportStatusResponseInterface::STATUS_FAILED);

        return $response;
    }
}

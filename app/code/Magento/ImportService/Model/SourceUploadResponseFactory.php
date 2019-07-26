<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\ObjectManagerInterface;
use Magento\ImportService\Api\Data\SourceCsvInterface;

/**
 * Factory class for @see \Magento\ImportService\Model\SourceUploadResponse
 */
class SourceUploadResponseFactory
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
        $instanceName = '\\Magento\\ImportService\\Model\\SourceUploadResponse'
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     *
     * @return SourceUploadResponse
     */
    public function create(array $data = []): SourceUploadResponse
    {
        return $this->objectManager->create($this->instanceName, $data);
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $error
     *
     * @return SourceUploadResponse
     */
    public function createFailure(string $error = ''): SourceUploadResponse
    {
        $response = $this->objectManager->create($this->instanceName);
        $response->setError($error);
        $response->setStatus(SourceCsvInterface::STATUS_FAILED);

        return $response;
    }
}

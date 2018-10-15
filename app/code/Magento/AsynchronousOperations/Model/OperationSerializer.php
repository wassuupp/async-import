<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\AsynchronousOperations\Model;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class OperationSerializer
 */
class OperationSerializer
{
    /**
     * @var Json
     */
    private $serializer;

    public function __construct(Json $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Serialize operation instance to JSON.
     *
     * @param OperationInterface $operation
     *
     * @return string
     */
    public function serialize(OperationInterface $operation): string
    {
        return $this->serializer->serialize($this->getSerializableData($operation));
    }

    /**
     * Unserialize into new operation instance from JSON.
     *
     * @param string $json
     *
     * @return OperationInterface
     */
    public function unserialize(string $json): OperationInterface
    {
        return new Operation($this->serializer->unserialize($json));
    }

    /**
     * Get data for serialize().
     *
     * @param OperationInterface $operation
     *
     * @return array
     */
    protected function getSerializableData(OperationInterface $operation): array
    {
        return [
            'bulk_uuid'      => $operation->getBulkUuid(),
            'topic_name'     => $operation->getTopicName(),
            'data'           => $operation->getSerializedData(),
            'result'         => $operation->getResultSerializedData(),
            'status'         => $operation->getStatus(),
            'error_code'     => $operation->getErrorCode(),
            'result_message' => $operation->getResultMessage(),
        ];
    }
}

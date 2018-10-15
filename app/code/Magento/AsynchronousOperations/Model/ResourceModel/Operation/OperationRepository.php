<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\AsynchronousOperations\Model\ResourceModel\Operation;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use Magento\AsynchronousOperations\Model\BulkStorageFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\MessageQueue\MessageValidator;
use Magento\Framework\MessageQueue\MessageEncoder;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Create operation for list of bulk operations.
 */
class OperationRepository
{
    /**
     * @var \Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory
     */
    private $operationFactory;

    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * @var MessageEncoder
     */
    private $messageEncoder;

    /**
     * @var MessageValidator
     */
    private $messageValidator;

    /**
     * @var BulkStorageFactory
     */
    private $storageFactory;

    /**
     * @param OperationInterfaceFactory $operationFactory
     * @param BulkStorageFactory $storageFactory
     * @param MessageValidator $messageValidator
     * @param MessageEncoder $messageEncoder
     * @param Json $jsonSerializer
     */
    public function __construct(
        OperationInterfaceFactory $operationFactory,
        BulkStorageFactory $storageFactory,
        MessageValidator $messageValidator,
        MessageEncoder $messageEncoder,
        Json $jsonSerializer
    ) {
        $this->operationFactory = $operationFactory;
        $this->jsonSerializer = $jsonSerializer;
        $this->messageEncoder = $messageEncoder;
        $this->messageValidator = $messageValidator;
        $this->storageFactory = $storageFactory;
    }

    /**
     * @param $topicName
     * @param $entityParams
     * @param $groupId
     * @return mixed
     * @throws LocalizedException
     */
    public function createByTopic($topicName, $entityParams, $groupId)
    {
        $storage = $this->storageFactory->create();
        $this->messageValidator->validate($topicName, $entityParams);
        $encodedMessage = $this->messageEncoder->encode($topicName, $entityParams);

        $serializedData = [
            'entity_id'        => null,
            'entity_link'      => '',
            'meta_information' => $encodedMessage,
        ];
        $data = [
            'data' => [
                OperationInterface::BULK_ID         => $groupId,
                OperationInterface::TOPIC_NAME      => $topicName,
                OperationInterface::SERIALIZED_DATA => $this->jsonSerializer->serialize($serializedData),
                OperationInterface::STATUS          => OperationInterface::STATUS_TYPE_OPEN,
            ],
        ];

        /** @var \Magento\AsynchronousOperations\Api\Data\OperationInterface $operation */
        $operation = $this->operationFactory->create($data);
        return $storage->saveOperation($operation);
    }
}

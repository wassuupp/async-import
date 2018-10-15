<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\AsynchronousOperations\Model\BulkStorage;

use \Magento\AsynchronousOperations\Api\Data\BulkSummaryInterface;
use \Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Model\BulkStorageInterface;
use Magento\AsynchronousOperations\Model\BulkSummarySerializer;
use Magento\AsynchronousOperations\Model\OperationSerializer;
use Magento\Framework\KeyValue\KeyValueStorageException;
use Magento\Framework\Redis\RedisStorage;

/**
 * Redis implementation of BulkStorageInterface
 */
class Redis implements BulkStorageInterface
{
    /** @var RedisStorage */
    private $redis;

    /**
     * @var BulkSummarySerializer
     */
    private $bulkSummarySerializer;

    /**
     * @var OperationSerializer
     */
    private $operationSerializer;

    /**
     * Redis constructor.
     *
     * @param RedisStorage $redis
     * @param BulkSummarySerializer $bulkSummarySerializer
     * @param OperationSerializer $operationSerializer
     */
    public function __construct(
        RedisStorage $redis,
        BulkSummarySerializer $bulkSummarySerializer,
        OperationSerializer $operationSerializer
    ) {
        $this->redis = $redis;
        $this->bulkSummarySerializer = $bulkSummarySerializer;
        $this->operationSerializer = $operationSerializer;
    }

    /**
     * Save bulk summary into Redis.
     *
     * @param BulkSummaryInterface $bulkSummary
     *
     * @return BulkSummaryInterface
     * @throws KeyValueStorageException
     */
    public function saveBulk(BulkSummaryInterface $bulkSummary): BulkSummaryInterface
    {
        $value = $this->bulkSummarySerializer->serialize($bulkSummary);

        try {
            $this->redis->add($bulkSummary->getBulkId(), $value);
        } catch (KeyValueStorageException $e) {
            $this->redis->update($bulkSummary->getBulkId(), $value);
        }

        return $bulkSummary;
    }

    /**
     * Save operation object into Redis.
     *
     * @param OperationInterface $operation
     *
     * @return OperationInterface
     * @throws KeyValueStorageException
     */
    public function saveOperation(OperationInterface $operation): OperationInterface
    {
        $key = self::getOperationKey($operation);
        $value = $this->operationSerializer->serialize($operation);

        try {
            $this->redis->add($key, $value);
        } catch (KeyValueStorageException $e) {
            $this->redis->update($key, $value);
        }

        $this->redis->addTags($key, self::getOperationTags($operation));

        return $operation;
    }

    public function findRetriablyFailedOperations(array $errorCodes, string $bulkUuid): array
    {
        // TODO: Implement findRetriablyFailedOperations() method.
    }

    public function deleteOperation(OperationInterface $operation): bool
    {
        // TODO: Implement deleteOperation() method.
    }

    public function deleteBulk(BulkSummaryInterface $bulkSummary): bool
    {
        // TODO: Implement deleteBulk() method.
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function commit(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rollback(): void
    {
    }

    /**
     * Get unique operation key for Redis.
     *
     * @param OperationInterface $operation
     *
     * @return string
     */
    private static function getOperationKey(OperationInterface $operation): string
    {
        return sprintf('%s:%s', $operation->getBulkUuid(), sha1($operation->getSerializedData()));
    }

    /**
     * Get Redis tags for operation.
     *
     * @param OperationInterface $operation
     *
     * @return string[]
     */
    private static function getOperationTags(OperationInterface $operation): array
    {
        $tags = [$operation->getBulkUuid()];

        $statusMap = [
            OperationInterface::STATUS_TYPE_COMPLETE             => 'complete',
            OperationInterface::STATUS_TYPE_RETRIABLY_FAILED     => 'retriablyFailed',
            OperationInterface::STATUS_TYPE_NOT_RETRIABLY_FAILED => 'notRetriablyFailed',
            OperationInterface::STATUS_TYPE_OPEN                 => 'open',
            OperationInterface::STATUS_TYPE_REJECTED             => 'rejected',
        ];

        if ($operation->getStatus() && array_key_exists($operation->getStatus(), $statusMap)) {
            $tags[] = 'BulkOperationStatus_' . $statusMap[$operation->getStatus()];
        }

        return $tags;
    }
}

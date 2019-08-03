<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

/**
 * Class ImportStatusResponse
 */
interface ImportStatusResponseInterface
{
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    public const STATUS = 'status';
    public const ERROR = 'error';
    public const UUID = 'uuid';
    public const ENTITY_TYPE = 'entity_type';
    public const USER_ID = 'user_id';
    public const USER_TYPE = 'user_type';
    public const ITEMS = 'items';

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get error if there is any with import process
     *
     * @return string|null
     */
    public function getError(): ?string;

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): string;

    /**
     * Get imported entity type
     *
     * @return string|null
     */
    public function getEntityType(): ?string;

    /**
     * Retrieve current user ID
     *
     * @return int|null
     */
    public function getUserId(): ?int;

    /**
     * Retrieve current user type
     *
     * @return int|null
     */
    public function getUserType(): ?int;

    /**
     * Get import items status
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface[]
     */
    public function getItems(): array;

    /**
     * Set import process status
     *
     * @param string $status
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setStatus(string $status): ImportStatusResponseInterface;

    /**
     * Set import process error if there is any
     *
     * @param string $error
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setError(string $error): ImportStatusResponseInterface;

    /**
     * Set uuid
     *
     * @param int $uuid
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setUuid(string $uuid): ImportStatusResponseInterface;

    /**
     * Set imported entity type
     *
     * @param string $entityType
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setEntityType(string $entityType): ImportStatusResponseInterface;

    /**
     * Set user id
     *
     * @param int:null $userId
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setUserId(?int $userId): ImportStatusResponseInterface;

    /**
     * Set user type
     *
     * @param int $userType
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setUserType(?int $userType): ImportStatusResponseInterface;

    /**
     * Set imported items
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface[] $items
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface
     */
    public function setItems(array $items): ImportStatusResponseInterface;
}

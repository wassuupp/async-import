<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Class ImportStatusResponse
 */
interface ImportStatusResponseInterface
{
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const STATUS = 'status';
    const ERROR = 'error';
    const UUID = 'uuid';
    const ENTITY_TYPE = 'entity_type';
    const USER_ID = 'user_id';
    const USER_TYPE = 'user_type';
    const ITEMS = 'items';

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get error
     *
     * @return string|null
     */
    public function getError();

    /**
     * Get uuid
     *
     * @return int
     */
    public function getUuid();

    /**
     * Get entity type
     *
     * @return string
     */
    public function getEntityType();

    /**
     * Retrieve current user ID
     *
     * @return int
     */
    public function getUserId();

    /**
     * Retrieve current user type
     *
     * @return int
     */
    public function getUserType();

    /**
     * Get import items status
     *
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface[]
     */
    public function getItems();

    /**
     * @param string $status
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setStatus($status);

    /**
     * @param string $error
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setError($error);

    /**
     * @param int $uuid
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setUuid($uuid);

    /**
     * @param string $entityType
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setEntityType($entityType);

    /**
     * @param int $userId
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setUserId($userId);

    /**
     * @param int $userType
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setUserType($userType);

    /**
     * @param \Magento\ImportService\Api\Data\ImportStatusResponseItemInterface[] $items
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function setItems($items);
}

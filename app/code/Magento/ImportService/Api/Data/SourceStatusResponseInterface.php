<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Class SourceStatusResponse
 */
interface SourceStatusResponseInterface
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
     * @return string|null
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
     * @return int|null
     */
    public function getUuid();

    /**
     * Get entity type
     *
     * @return string|null
     */
    public function getEntityType();

    /**
     * Retrieve current user ID
     *
     * @return int|null
     */
    public function getUserId();

    /**
     * Retrieve current user type
     *
     * @return int|null
     */
    public function getUserType();

    /**
     * Get import items status
     *
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface[]|null
     */
    public function getItems();

    /**
     * @param $status
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setStatus($status);

    /**
     * @param $error
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setError($error);

    /**
     * @param $uuid
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setUuid($uuid);

    /**
     * @param $entityType
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setEntityType($entityType);

    /**
     * @param $userId
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setUserId($userId);

    /**
     * @param $userType
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setUserType($userType);

    /**
     * @param $items
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function setItems($items);

    /**
     * @param $item
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function addItem($item);
}

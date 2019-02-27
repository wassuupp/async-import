<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceStatusResponseInterface;

class SourceStatusResponse extends AbstractModel implements SourceStatusResponseInterface
{
    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get error
     *
     * @return string|null
     */
    public function getError()
    {
        return $this->getData(self::ERROR);
    }

    /**
     * Get uuid
     *
     * @return int|null
     */
    public function getUuid()
    {
        return $this->getData(self::UUID);
    }

    /**
     * Get entity type
     *
     * @return string|null
     */
    public function getEntityType()
    {
        return $this->getData(self::ENTITY_TYPE);
    }

    /**
     * Get user id
     *
     * @return int|null
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Get user type
     *
     * @return int|null
     */
    public function getUserType()
    {
        return $this->getData(self::USER_TYPE);
    }

    /**
     * Get items
     *
     * @return int|null
     */
    public function getItems()
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $error
     * @return $this
     */
    public function setError($error)
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * @param $uuid
     * @return $this
     */
    public function setUuid($uuid)
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * @param $entityType
     * @return $this
     */
    public function setEntityType($entityType)
    {
        return $this->setData(self::ENTITY_TYPE, $entityType);
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * @param $userType
     * @return $this
     */
    public function setUserType($userType)
    {
        return $this->setData(self::USER_TYPE, $userType);
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        return $this->setData(self::ITEMS, $items);
    }

    /**
     * @param $item
     * @return $this
     */
    public function addItem($item)
    {
        $items = $this->getItems();

        if(is_null($items))
            $items = [];
        $items[] = $item;

        return $this->setItems($items);
    }
}

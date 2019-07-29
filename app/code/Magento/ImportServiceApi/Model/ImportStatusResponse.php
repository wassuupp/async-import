<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportServiceApi\Api\Data\ImportStatusResponseInterface;

class ImportStatusResponse extends AbstractModel implements ImportStatusResponseInterface
{
    /**
     * Get import status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get error if there is any with import process
     *
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->getData(self::ERROR);
    }

    /**
     * Get uuid
     *
     * @return int
     */
    public function getUuid(): string
    {
        return $this->getData(self::UUID);
    }

    /**
     * Get imported entity type
     *
     * @return string
     */
    public function getEntityType(): ?string
    {
        return $this->getData(self::ENTITY_TYPE);
    }

    /**
     * Retrieve current user ID
     *
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Retrieve current user type
     *
     * @return int
     */
    public function getUserType(): ?int
    {
        return $this->getData(self::USER_TYPE);
    }

    /**
     * Get import items status
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface[]
     */
    public function getItems(): array
    {
        return $this->getData(self::ITEMS);
    }

    /**
     * Set import process status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): ImportStatusResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set import process error if there is any
     *
     * @param string $error
     * @return $this
     */
    public function setError(string $error): ImportStatusResponseInterface
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * Set uuid
     *
     * @param int $uuid
     * @return $this
     */
    public function setUuid(string $uuid): ImportStatusResponseInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * Set imported entity type
     *
     * @param string $entityType
     * @return $this
     */
    public function setEntityType(string $entityType): ImportStatusResponseInterface
    {
        return $this->setData(self::ENTITY_TYPE, $entityType);
    }

    /**
     * Set user id
     *
     * @param int $userId
     * @return $this
     */
    public function setUserId(?int $userId): ImportStatusResponseInterface
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Set user type
     *
     * @param int $userType
     * @return $this
     */
    public function setUserType(?int $userType): ImportStatusResponseInterface
    {
        return $this->setData(self::USER_TYPE, $userType);
    }

    /**
     * Set imported items
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items): ImportStatusResponseInterface
    {
        return $this->setData(self::ITEMS, $items);
    }
}

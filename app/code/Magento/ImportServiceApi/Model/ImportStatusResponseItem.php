<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface;

class ImportStatusResponseItem extends AbstractModel implements ImportStatusResponseItemInterface
{
    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->getData(self::UUID);
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get serialized data
     *
     * @return string
     */
    public function getSerializedData(): string
    {
        return $this->getData(self::SERIALIZED_DATA);
    }

    /**
     * Get serialized data result
     *
     * @return string
     */
    public function getResultSerializedData(): string
    {
        return $this->getData(self::RESULT_SERIALIZED_DATA);
    }

    /**
     * Get error code
     *
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->getData(self::ERROR_CODE);
    }

    /**
     * Get result message
     *
     * @return string
     */
    public function getResultMessage(): string
    {
        return $this->getData(self::RESULT_MESSAGE);
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return $this
     */
    public function setUuid(string $uuid): ImportStatusResponseItemInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * Set imported status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): ImportStatusResponseItemInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set serialized data
     *
     * @param string $serializedData
     * @return $this
     */
    public function setSerializedData(string $serializedData): ImportStatusResponseItemInterface
    {
        return $this->setData(self::SERIALIZED_DATA, $serializedData);
    }

    /**
     * Set serialized result data
     *
     * @param string $resultSerializedData
     * @return $this
     */
    public function setResultSerializedData(string $resultSerializedData): ImportStatusResponseItemInterface
    {
        return $this->setData(self::RESULT_SERIALIZED_DATA, $resultSerializedData);
    }

    /**
     * Set error code if occured
     *
     * @param string $errorCode
     * @return $this
     */
    public function setErrorCode(string $errorCode): ImportStatusResponseItemInterface
    {
        return $this->setData(self::ERROR_CODE, $errorCode);
    }

    /**
     * Set result message for process
     *
     * @param string $resultMessage
     * @return $this
     */
    public function setResultMessage(string $resultMessage): ImportStatusResponseItemInterface
    {
        return $this->setData(self::RESULT_MESSAGE, $resultMessage);
    }
}

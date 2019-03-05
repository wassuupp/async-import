<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\ImportStatusResponseItemInterface;

class ImportStatusResponseItem extends AbstractModel implements ImportStatusResponseItemInterface
{
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
     * Get status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get serialized data
     *
     * @return string|null
     */
    public function getSerializedData()
    {
        return $this->getData(self::SERIALIZED_DATA);
    }

    /**
     * Get serialized data result
     *
     * @return string|null
     */
    public function getResultSerializedData()
    {
        return $this->getData(self::RESULT_SERIALIZED_DATA);
    }

    /**
     * Get error code
     *
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->getData(self::ERROR_CODE);
    }

    /**
     * Get result message
     *
     * @return string|null
     */
    public function getResultMessage()
    {
        return $this->getData(self::RESULT_MESSAGE);
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
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $serializedData
     * @return $this
     */
    public function setSerializedData($serializedData)
    {
        return $this->setData(self::SERIALIZED_DATA, $serializedData);
    }

    /**
     * @param $resultSerializedData
     * @return $this
     */
    public function setResultSerializedData($resultSerializedData)
    {
        return $this->setData(self::RESULT_SERIALIZED_DATA, $resultSerializedData);
    }

    /**
     * @param $errorCode
     * @return $this
     */
    public function setErrorCode($errorCode)
    {
        return $this->setData(self::ERROR_CODE, $errorCode);
    }

    /**
     * @param $resultMessage
     * @return $this
     */
    public function setResultMessage($resultMessage)
    {
        return $this->setData(self::RESULT_MESSAGE, $resultMessage);
    }
}

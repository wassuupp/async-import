<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\ImportResponseInterface;

class ImportResponse extends AbstractModel implements ImportResponseInterface
{   
    /**
     * Get file ID
     *
     * @return int
     */
    public function getSourceId()
    {
        return $this->getData(self::SOURCE_ID);
    }

    /**
     * Get file status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get error
     * @return string
     */
    public function getError()
    {
        return $this->getData(self::ERROR);
    }

    /**
     * @param $sourceId
     * @return ImportResponse|mixed
     */
    public function setSourceId($sourceId)
    {
        return $this->setData(self::SOURCE_ID, $sourceId);
    }

    /**
     * @param $status
     * @return ImportResponse|mixed
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $error
     * @return ImportResponse|mixed
     */
    public function setError($error)
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * @return $this
     */
    public function setCompleted()
    {
        $this->setStatus(self::STATUS_COMPLETED);
        return $this;
    }

    /**
     * @return $this
     */
    public function setFailed()
    {
        $this->setStatus(self::STATUS_FAILED);
        return $this;
    }
}
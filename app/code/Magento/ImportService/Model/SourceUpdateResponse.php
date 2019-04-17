<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceUpdateResponseInterface;

class SourceUpdateResponse extends AbstractModel implements SourceUpdateResponseInterface
{
    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @param string $status
     * @return mixed
     */
    public function setStatus(string $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function setMessage(string $message)
    {
        return $this->setData(self::MESSAGE, $message);
    }
}

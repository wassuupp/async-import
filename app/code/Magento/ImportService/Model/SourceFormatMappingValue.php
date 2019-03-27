<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceFormatMappingValueInterface;

/**
 * Class SourceFormatMappingValue
 */
class SourceFormatMappingValue extends AbstractModel implements SourceFormatMappingValueInterface
{
    /**
     * @inheritDoc
     */
    public function getOldValue()
    {
        return $this->getData(self::OLD_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setOldValue($oldValue)
    {
        return $this->setData(self::OLD_VALUE, $oldValue);
    }

    /**
     * @inheritDoc
     */
    public function getNewValue()
    {
        return $this->getData(self::NEW_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setNewValue($newValue)
    {
        return $this->setData(self::NEW_VALUE, $newValue);
    }
}

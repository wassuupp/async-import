<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceFormatInterface;

/**
 * Class SourceFormat
 */
class SourceFormat extends AbstractModel implements SourceFormatInterface
{
    /**
     * @inheritDoc
     */
    public function getCsvSeparator()
    {
        return $this->getData(self::CSV_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setCsvSeparator($csvSeparator)
    {
        return $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getCsvEnclosure()
    {
        return $this->getData(self::CSV_ENCLOSURE);
    }

    /**
     * @inheritDoc
     */
    public function setCsvEnclosure($csvEnclosure)
    {
        return $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @inheritDoc
     */
    public function getCsvDelimiter()
    {
        return $this->getData(self::CSV_DELIMITER);
    }

    /**
     * @inheritDoc
     */
    public function setCsvDelimiter($csvDelimiter)
    {
        return $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }

    /**
     * @inheritDoc
     */
    public function getMultipleValueSeparator()
    {
        return $this->getData(self::MULTIPLE_VALUE_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setMultipleValueSeparator($multipleValueSeparator)
    {
        return $this->setData(self::MULTIPLE_VALUE_SEPARATOR, $multipleValueSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getMapping()
    {
        return $this->getData(self::MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setMapping($mapping)
    {
        return $this->setData(self::MAPPING, $mapping);
    }
}

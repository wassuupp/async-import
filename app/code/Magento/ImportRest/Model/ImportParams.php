<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportRest\Model;

use Magento\Framework\DataObject;
use Magento\ImportRest\Api\Data\ImportParamsInterface;

class ImportParams extends DataObject implements ImportParamsInterface
{

    /**
     * @inheritDoc
     */
    public function getBehavior()
    {
        return $this->getData(self::BEHAVIOR);
    }

    /**
     * @inheritDoc
     */
    public function setBehavior($behavior)
    {
        return $this->setData(self::BEHAVIOR, $behavior);
    }

    /**
     * @inheritDoc
     */
    public function getImportFile()
    {
        return $this->getData(self::IMPORT_FILE);
    }

    /**
     * @inheritDoc
     */
    public function setImportFile($importFile)
    {
        return $this->setData(self::IMPORT_FILE, $importFile);
    }

    /**
     * @inheritDoc
     */
    public function getImportImageArchive()
    {
        return $this->getData(self::IMG_ARCHIVE_FILE);
    }

    /**
     * @inheritDoc
     */
    public function setImportImageArchive($importImageArchive)
    {
        return $this->setData(self::IMG_ARCHIVE_FILE, $importImageArchive);
    }

    /**
     * @inheritDoc
     */
    public function getImportImagesFileDir()
    {
        return $this->getData(self::IMG_FILE_DIR);
    }

    /**
     * @inheritDoc
     */
    public function setImportImagesFileDir($importImagesFileDir)
    {
        return $this->setData(self::IMG_FILE_DIR, $importImagesFileDir);
    }

    /**
     * @inheritDoc
     */
    public function getAllowedErrorCount()
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }

    /**
     * @inheritDoc
     */
    public function setAllowedErrorCount($allowedErrorCount)
    {
        return $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * @inheritDoc
     */
    public function getValidationStrategy()
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @inheritDoc
     */
    public function setValidationStrategy($validationStrategy)
    {
        return $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
    }

    /**
     * @inheritDoc
     */
    public function getSeparator()
    {
        return $this->getData(self::SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setSeparator($separator)
    {
        return $this->setData(self::SEPARATOR, $separator);
    }

    /**
     * @inheritDoc
     */
    public function getEnclosure()
    {
        return $this->getData(self::ENCLOSURE);
    }

    /**
     * @inheritDoc
     */
    public function setEnclosure($enclosure)
    {
        return $this->setData(self::ENCLOSURE, $enclosure);
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
    public function getEmptyAttributeValueConstant()
    {
        return $this->getData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT);
    }

    /**
     * @inheritDoc
     */
    public function setEmptyAttributeValueConstant($emptyAttributeValueConstant)
    {
        return $this->setData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT, $emptyAttributeValueConstant);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\ImportConfigInterface;

/**
 * Class ImportConfig
 * @package Magento\ImportService\Model
 */
class ImportConfig extends AbstractExtensibleModel implements ImportConfigInterface
{
    /**
     * @return string
     */
    public function getProfileUuid(): string
    {
        return $this->getData(self::PROFILE_UUID);
    }

    /**
     * @param string $profileUuid
     */
    public function setProfileUuid(string $profileUuid): void
    {
        $this->setData(self::PROFILE_UUID, $profileUuid);
    }

    /**
     * @return string
     */
    public function getBehaviour(): string
    {
        return $this->getData(self::BEHAVIOUR);
    }

    /**
     * @param string $behaviour
     */
    public function setBehaviour(string $behaviour): void
    {
        $this->setData(self::BEHAVIOUR, $behaviour);
    }

    /**
     * @return string
     */
    public function getImportImageArchive(): string
    {
        return $this->getData(self::IMPORT_IMAGE_ARCHIVE);
    }

    /**
     * @param string $importImageArchive
     */
    public function setImportImageArchive(string $importImageArchive): void
    {
        $this->setData(self::IMPORT_IMAGE_ARCHIVE, $importImageArchive);
    }

    /**
     * @return string
     */
    public function getImportImagesFileDir(): string
    {
        return $this->getData(self::IMPORT_IMAGES_FILE_DIR);
    }

    /**
     * @param string $importImagesFileDir
     */
    public function setImportImagesFileDir(string $importImagesFileDir): void
    {
        $this->setData(self::IMPORT_IMAGES_FILE_DIR, $importImagesFileDir);
    }

    /**
     * @return string
     */
    public function getAllowedErrorCount(): string
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }

    /**
     * @param int $allowedErrorCount
     */
    public function setAllowedErrorCount(int $allowedErrorCount): void
    {
        $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * @return string
     */
    public function getValidationStrategy(): string
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @param string $validationStrategy
     */
    public function setValidationStrategy(string $validationStrategy): void
    {
        $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
    }

    /**
     * @return string
     */
    public function getEmptyAttributeValueConstant(): string
    {
        return $this->getData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT);
    }

    /**
     * @param string $emptyAttributeValueConstant
     */
    public function setEmptyAttributeValueConstant(string $emptyAttributeValueConstant): void
    {
        $this->setData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT, $emptyAttributeValueConstant);
    }

    /**
     * @return string
     */
    public function getCsvSeparator(): string
    {
        return $this->getData(self::CSV_SEPARATOR);
    }

    /**
     * @param string $csvSeparator
     */
    public function setCsvSeparator(string $csvSeparator): void
    {
        $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @return string
     */
    public function getCsvEnclosure(): string
    {
        return $this->getData(self::CSV_ENCLOSURE);
    }

    /**
     * @param string $csvEnclosure
     */
    public function setCsvEnclosure(string $csvEnclosure): void
    {
        $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @return string
     */
    public function getCsvDelimiter(): string
    {
        return $this->getData(self::CSV_DELIMITER);
    }

    /**
     * @param string $csvDelimiter
     */
    public function setCsvDelimiter(string $csvDelimiter): void
    {
        $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }

    /**
     * @return string
     */
    public function getMultipleValueSeparator(): string
    {
        return $this->getData(self::MULTIPLE_VALUE_SEPARATOR);
    }

    /**
     * @param string $multipleValueSeparator
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): void
    {
        $this->setData(self::MULTIPLE_VALUE_SEPARATOR, $multipleValueSeparator);
    }
}

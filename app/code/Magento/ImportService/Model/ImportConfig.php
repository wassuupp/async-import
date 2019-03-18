<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\ImportConfigExtensionInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;

/**
 * Class ImportConfig
 */
class ImportConfig extends AbstractExtensibleModel implements ImportConfigInterface
{
    /**
     * @inheritdoc
     */
    public function getProfileUuid(): string
    {
        return $this->getData(self::PROFILE_UUID);
    }

    /**
     * @inheritdoc
     */
    public function setProfileUuid(string $profileUuid): void
    {
        $this->setData(self::PROFILE_UUID, $profileUuid);
    }

    /**
     * @inheritdoc
     */
    public function getBehaviour(): string
    {
        return $this->getData(self::BEHAVIOUR);
    }

    /**
     * @inheritdoc
     */
    public function setBehaviour(string $behaviour): void
    {
        $this->setData(self::BEHAVIOUR, $behaviour);
    }

    /**
     * @inheritdoc
     */
    public function getImportImageArchive(): string
    {
        return $this->getData(self::IMPORT_IMAGE_ARCHIVE);
    }

    /**
     * @inheritdoc
     */
    public function setImportImageArchive(string $importImageArchive): void
    {
        $this->setData(self::IMPORT_IMAGE_ARCHIVE, $importImageArchive);
    }

    /**
     * @inheritdoc
     */
    public function getImportImagesFileDir(): string
    {
        return $this->getData(self::IMPORT_IMAGES_FILE_DIR);
    }

    /**
     * @inheritdoc
     */
    public function setImportImagesFileDir(string $importImagesFileDir): void
    {
        $this->setData(self::IMPORT_IMAGES_FILE_DIR, $importImagesFileDir);
    }

    /**
     * @inheritdoc
     */
    public function getAllowedErrorCount(): int
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setAllowedErrorCount(int $allowedErrorCount): void
    {
        $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * @inheritdoc
     */
    public function getValidationStrategy(): string
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @inheritdoc
     */
    public function setValidationStrategy(string $validationStrategy): void
    {
        $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
    }

    /**
     * @inheritdoc
     */
    public function getEmptyAttributeValueConstant(): string
    {
        return $this->getData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT);
    }

    /**
     * @inheritdoc
     */
    public function setEmptyAttributeValueConstant(string $emptyAttributeValueConstant): void
    {
        $this->setData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT, $emptyAttributeValueConstant);
    }

    /**
     * @inheritdoc
     */
    public function getCsvSeparator(): string
    {
        return $this->getData(self::CSV_SEPARATOR);
    }

    /**
     * @inheritdoc
     */
    public function setCsvSeparator(string $csvSeparator): void
    {
        $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @inheritdoc
     */
    public function getCsvEnclosure(): string
    {
        return $this->getData(self::CSV_ENCLOSURE);
    }

    /**
     * @inheritdoc
     */
    public function setCsvEnclosure(string $csvEnclosure): void
    {
        $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @inheritdoc
     */
    public function getCsvDelimiter(): string
    {
        return $this->getData(self::CSV_DELIMITER);
    }

    /**
     * @inheritdoc
     */
    public function setCsvDelimiter(string $csvDelimiter): void
    {
        $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }

    /**
     * @inheritdoc
     */
    public function getMultipleValueSeparator(): string
    {
        return $this->getData(self::MULTIPLE_VALUE_SEPARATOR);
    }

    /**
     * @inheritdoc
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): void
    {
        $this->setData(self::MULTIPLE_VALUE_SEPARATOR, $multipleValueSeparator);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ImportConfigExtensionInterface
    {
        // TODO: Implement getExtensionAttributes() method.
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(ImportConfigExtensionInterface $extension): void
    {
        // TODO: Implement setExtensionAttributes() method.
    }
}

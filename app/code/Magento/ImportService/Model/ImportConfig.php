<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportServiceApi\Api\Data\ImportConfigExtensionInterface;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportServiceApi\Api\Data\ImportMappingInterface;

/**
 * Class ImportConfig
 */
class ImportConfig extends AbstractExtensibleModel implements ImportConfigInterface
{

    /**
     * @inheritdoc
     */
    public function getImportType(): string
    {
        return $this->getData(self::IMPORT_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function setImportType(string $importType): void
    {
        $this->setData(self::IMPORT_TYPE, $importType);
    }

    /**
     * @inheritdoc
     */
    public function getImportStrategy(): string
    {
        return $this->getData(self::IMPORT_STRATEGY);
    }

    /**
     * @inheritdoc
     */
    public function setImportStrategy(string $importStrategy): void
    {
        $this->setData(self::IMPORT_STRATEGY, $importStrategy);
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
    public function getMapping(): ?array
    {
        return $this->getData(self::MAPPING);
    }

    /**
     * @inheritdoc
     */
    public function setMapping(?array $importMapping): void
    {
        $this->setData(self::MAPPING, $importMapping);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ImportConfigExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(ImportConfigExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}

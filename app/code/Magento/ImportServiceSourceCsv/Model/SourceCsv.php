<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvExtensionInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;

/**
 * Class Source
 */
class SourceCsv extends AbstractExtensibleModel implements SourceCsvInterface
{

    /**
     * Source constructor
     */
    protected function _construct()
    {
        $this->_init(SourceResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * @inheritDoc
     */
    public function setUuid(string $uuid): SourceCsvInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * @inheritDoc
     */
    public function getSourceType(): string
    {
        return $this->getData(self::SOURCE_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceType(string $sourceType): SourceCsvInterface
    {
        return $this->setData(self::SOURCE_TYPE, $sourceType);
    }

    /**
     * @inheritDoc
     */
    public function getImportType(): string
    {
        return $this->getData(self::IMPORT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setImportType(string $importType): SourceCsvInterface
    {
        return $this->setData(self::IMPORT_TYPE, $importType);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): ?string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(?string $status): SourceCsvInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getImportData(): string
    {
        return $this->getData(self::IMPORT_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setImportData(string $importData): SourceCsvInterface
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getFormat(): ?SourceCsvFormatInterface
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat(SourceCsvFormatInterface $format): SourceCsvInterface
    {
        return $this->setData(self::FORMAT, $format);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(?string $date): SourceCsvInterface
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?SourceCsvExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        SourceCsvExtensionInterface $extensionAttributes
    ): SourceCsvInterface {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}


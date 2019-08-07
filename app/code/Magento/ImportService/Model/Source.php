<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\ImportServiceApi\Api\Data\SourceExtensionInterface;
use Magento\ImportServiceApi\Api\Data\SourceInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;
use Magento\ImportService\Model\SourceCsvFormatFactory as FormatFactory;

/**
 * Class Source
 */
class Source extends AbstractExtensibleModel implements SourceInterface
{
    public const CACHE_TAG = 'magento_import_service_source';

    /**
     * Source format factory
     *
     * @var FormatFactory
     */
    private $formatFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param FormatFactory $formatFactory
     * @param SerializerInterface $serializer
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        FormatFactory $formatFactory,
        SerializerInterface $serializer,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->formatFactory = $formatFactory;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
        $this->serializer = $serializer;
    }

    /**
     * Source constructor
     */
    protected function _construct()
    {
        $this->_init(SourceResource::class);
    }

    /**
     * Get unique page cache identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
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
    public function setUuid(string $uuid): SourceInterface
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
    public function setSourceType(string $sourceType): SourceInterface
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
    public function setImportType(string $importType): SourceInterface
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
    public function setStatus(?string $status): SourceInterface
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
    public function setImportData(string $importData): SourceInterface
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getFormat(): ?array
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat(array $format): SourceInterface
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
    public function setCreatedAt(?string $date): SourceInterface
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?SourceExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        SourceExtensionInterface $extensionAttributes
    ): SourceInterface {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
//        $this->decorate();
        parent::afterLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function decorate()
    {
        $formatJson = $this->getData('format');

        if (isset($formatJson)) {

            /** get format json string and decode */
            $formatJson = $this->serializer->unserialize($formatJson);

            /** set decoded json string and object to formatted source */
            $format = $this->formatFactory->create()->setData($formatJson);
            $this->setData('format', $format);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
//        /** get format object */
//        $format = $this->getFormat();
//
//        if (!isset($format)) {
//            $data = [
//                SourceCsvFormatInterface::CSV_SEPARATOR => SourceCsvFormatInterface::DEFAULT_CSV_SEPARATOR,
//                SourceCsvFormatInterface::CSV_ENCLOSURE => SourceCsvFormatInterface::DEFAULT_CSV_ENCLOSURE,
//                SourceCsvFormatInterface::CSV_DELIMITER => SourceCsvFormatInterface::DEFAULT_CSV_DELIMITER,
//                SourceCsvFormatInterface::MULTIPLE_VALUE_SEPARATOR => SourceCsvFormatInterface::DEFAULT_MULTIPLE_VALUE_SEPARATOR
//            ];
//            /** create format object and set default values */
//            $format = $this->formatFactory->create()->setData($data);
//        }
//
//        /** set format json string to format field */
//        $this->setData('format', $format->toJson());

        parent::beforeSave();
    }
}

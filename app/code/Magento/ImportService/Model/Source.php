<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\SourceExtensionInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;
use Magento\ImportService\Model\SourceFormatFactory as FormatFactory;
use Magento\ImportService\Model\SourceFormatMappingFactory as MappingFactory;
use Magento\ImportService\Model\SourceFormatMappingValueFactory as MappingValueFactory;

/**
 * Class Source
 */
class Source extends AbstractExtensibleModel implements SourceInterface
{
    const CACHE_TAG = 'magento_import_service_source';

    /**
     * Source format factory
     *
     * @var FormatFactory
     */
    private $formatFactory;

    /**
     * Source format mapping factory
     *
     * @var MappingFactory
     */
    private $mappingFactory;

    /**
     * Source format mapping value factory
     *
     * @var MappingValueFactory
     */
    private $mappingValueFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param FormatFactory $formatFactory
     * @param MappingFactory $mappingFactory
     * @param MappingValueFactory $mappingValueFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        FormatFactory $formatFactory,
        MappingFactory $mappingFactory,
        MappingValueFactory $mappingValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->formatFactory = $formatFactory;
        $this->mappingFactory = $mappingFactory;
        $this->mappingValueFactory = $mappingValueFactory;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource, $resourceCollection, $data);
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
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function getSourceId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function getSourceType()
    {
        return $this->getData(self::SOURCE_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceType($sourceType)
    {
        return $this->setData(self::SOURCE_TYPE, $sourceType);
    }

    /**
     * @inheritDoc
     */
    public function getImportType()
    {
        return $this->getData(self::IMPORT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setImportType($importType)
    {
        return $this->setData(self::IMPORT_TYPE, $importType);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getImportData()
    {
        return $this->getData(self::IMPORT_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setImportData($importData)
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getFormat()
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat($format)
    {
        return $this->setData(self::FORMAT, $format);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(SourceExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
        $formatJson = $this->getFormat();

        /** get format json string and decode */
        $formatJson = json_decode($formatJson, true);

        /** check for format mapping field, decode json string and convert into object */
        if(isset($formatJson['mapping'])) {
            $formatMapping = [];
            foreach($formatJson['mapping'] as $mappingJson) {
                $mappingJson = json_decode($mappingJson, true);
                /** check for format mapping value field, decode json string and convert into object */
            	if(isset($mappingJson['values_mapping'])) {
            		$valuesMapping = [];
            		foreach($mappingJson['values_mapping'] as $valuesJson) {
            			$valuesJson = json_decode($valuesJson, true);
                		$valuesMapping[] = $this->mappingValueFactory->create()->setData($valuesJson);
            		}
            		$mappingJson['values_mapping'] = $valuesMapping;
            	}
                $formatMapping[] = $this->mappingFactory->create()->setData($mappingJson);
            }
            $formatJson['mapping'] = $formatMapping;
        }

        /** set decoded json string and object to formatted source */
        $format = $this->formatFactory->create()->setData($formatJson);
        $this->setFormat($format);

        parent::afterLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        /** get format object */
        $format = $this->getFormat();

        /** get list of mapping and convert it into json and set to format */
        $formatMapping = $format->getMapping();

        /** check for mapping exist or not*/
        if(isset($formatMapping)) {
	        foreach($formatMapping as &$mapping) {
	            $valuesMapping = $mapping->getValuesMapping();
        		/** check for mapping exist or not and convert it into json */
	            if(isset($valuesMapping)) {
	            	foreach($valuesMapping as &$values) {
		            	$values = $values->toJson();
		            }
		            $mapping->setValuesMapping($valuesMapping);
	            }
	            $mapping = $mapping->toJson();
	        }
        	$format->setMapping($formatMapping);
        }

        /** set format json string to format field */
        $this->setFormat($format->toJson());
        parent::beforeSave();
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface SourceFormatMappingInterface
 */
interface SourceFormatMappingInterface
{
    const SOURCE_ATTRIBUTE = 'source_attribute';
    const DESTINATION_ATTRIBUTE = 'destination_attribute';
    const PROCESSING_RULES = 'processing_rules';
    const TAXONOMY = 'taxonomy';
    const VALUES_MAPPING = 'values_mapping';

    /**
     * @return string
     */
    public function getSourceAttribute();

    /**
     * Set Source Attribute
     *
     * @param string $sourceAttribute
     * @return $this
     */
    public function setSourceAttribute($sourceAttribute);

    /**
     * @return string
     */
    public function getDestinationAttribute();

    /**
     * Set destination attribute
     *
     * @param string $destinationAttribute
     * @return $this
     */
    public function setDestinationAttribute($destinationAttribute);

    /**
     * @return string
     */
    public function getProcessingRules();

    /**
     * Set processing rules
     *
     * @param string $processingRules
     * @return $this
     */
    public function setProcessingRules($processingRules);

    /**
     * @return string
     */
    public function getTaxonomy();

    /**
     * Set taxonomy
     *
     * @param string $taxonomy
     * @return $this
     */
    public function setTaxonomy($taxonomy);

    /**
     * @return \Magento\ImportService\Api\Data\SourceFormatMappingValueInterface[]
     */
    public function getValuesMapping();

    /**
     * Set Value Mapping
     *
     * @param \Magento\ImportService\Api\Data\SourceFormatMappingValueInterface[] $valuesMapping
     * @return $this
     */
    public function setValuesMapping($valuesMapping);
}
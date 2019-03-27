<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface SourceFormatInterface
 */
interface SourceFormatInterface
{
    const CSV_SEPARATOR = 'csv_separator';
    const CSV_ENCLOSURE = 'csv_enclosure';
    const CSV_DELIMITER = 'csv_delimiter';
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';
    const MAPPING = 'mapping';

    /**
     * @return string
     */
    public function getCsvSeparator();

    /**
     * Set CSV Separator
     *
     * @param string $csvSeparator
     * @return $this
     */
    public function setCsvSeparator($csvSeparator);

    /**
     * @return string
     */
    public function getCsvEnclosure();

    /**
     * Set CSV Enclosure
     *
     * @param string $csvEnclosure
     * @return $this
     */
    public function setCsvEnclosure($csvEnclosure);

    /**
     * @return string
     */
    public function getCsvDelimiter();

    /**
     * Set CSV Delimiter
     *
     * @param string $csvDelimiter
     * @return $this
     */
    public function setCsvDelimiter($csvDelimiter);

    /**
     * @return string
     */
    public function getMultipleValueSeparator();

    /**
     * Set Multiple Value Separator
     *
     * @param string $multipleValueSeparator
     * @return $this
     */
    public function setMultipleValueSeparator($multipleValueSeparator);

    /**
     * @return \Magento\ImportService\Api\Data\SourceFormatMappingInterface[]
     */
    public function getMapping();

    /**
     * Set multiple mapping
     *
     * @param \Magento\ImportService\Api\Data\SourceFormatMappingInterface[] $mapping
     * @return $this
     */
    public function setMapping($mapping);
}
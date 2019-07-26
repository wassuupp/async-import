<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

/**
 * Interface SourceCsvFormatInterface
 */
interface SourceCsvFormatInterface
{
    const CSV_SEPARATOR = 'csv_separator';
    const CSV_ENCLOSURE = 'csv_enclosure';
    const CSV_DELIMITER = 'csv_delimiter';
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    const DEFAULT_CSV_SEPARATOR = ',';
    const DEFAULT_CSV_ENCLOSURE = '"';
    const DEFAULT_CSV_DELIMITER = ',';
    const DEFAULT_MULTIPLE_VALUE_SEPARATOR = '|';

    /**
     * @return string|null
     */
    public function getCsvSeparator(): ?string;

    /**
     * Set CSV Separator
     *
     * @param string $csvSeparator
     * @return \Magento\ImportServiceApi\Api\Data\SourceCsvFormatInterface
     */
    public function setCsvSeparator(string $csvSeparator): SourceCsvFormatInterface;

    /**
     * @return string|null
     */
    public function getCsvEnclosure(): ?string;

    /**
     * Set CSV Enclosure
     *
     * @param string $csvEnclosure
     * @return \Magento\ImportServiceApi\Api\Data\SourceCsvFormatInterface
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceCsvFormatInterface;

    /**
     * @return string|null
     */
    public function getCsvDelimiter(): ?string;

    /**
     * Set CSV Delimiter
     *
     * @param string $csvDelimiter
     * @return \Magento\ImportServiceApi\Api\Data\SourceCsvFormatInterface
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceCsvFormatInterface;

    /**
     * @return string|null
     */
    public function getMultipleValueSeparator(): ?string;

    /**
     * Set Multiple Value Separator
     *
     * @param string $multipleValueSeparator
     * @return \Magento\ImportServiceApi\Api\Data\SourceCsvFormatInterface
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): SourceCsvFormatInterface;

}
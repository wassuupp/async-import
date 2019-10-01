<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Describes how to parse data
 *
 * @api
 */
interface CsvFormatInterface extends ExtensibleDataInterface
{
    public const FORMAT_TYPE = 'csv';

    public const ESCAPE = 'escape';
    public const ENCLOSURE = 'enclosure';
    public const DELIMITER = 'delimiter';
    public const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    public const DEFAULT_ESCAPE = '\\';
    public const DEFAULT_ENCLOSURE = '"';
    public const DEFAULT_DELIMITER = ',';
    public const DEFAULT_MULTIPLE_VALUE_SEPARATOR = '|';

    /**
     * Get CSV Escape
     *
     * @return string|null
     */
    public function getEscape(): ?string;

    /**
     * Get CSV Enclosure
     *
     * @return string|null
     */
    public function getEnclosure(): ?string;

    /**
     * Get CSV Delimiter
     *
     * @return string|null
     */
    public function getDelimiter(): ?string;

    /**
     * Get Multiple Value Separator
     *
     * @return string|null
     */
    public function getMultipleValueSeparator(): ?string;

    /**
     * Get existing extension attributes object
     *
     * @return \Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatExtensionInterface|null
     */
    public function getExtensionAttributes(): ?CsvFormatExtensionInterface;
}

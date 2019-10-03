<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatExtensionInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;

/**
 * @inheritdoc
 */
class CsvFormat implements CsvFormatInterface
{
    /**
     * @var string|null
     */
    private $escape;

    /**
     * @var string|null
     */
    private $enclosure;

    /**
     * @var string|null
     */
    private $delimiter;

    /**
     * @var string|null
     */
    private $multipleValueSeparator;

    /**
     * @var CsvFormatExtensionInterface|null
     */
    private $extensionAttributes;

    /**
     * @param string|null $escape
     * @param string|null $enclosure
     * @param string|null $delimiter
     * @param string|null $multipleValueSeparator
     * @param CsvFormatExtensionInterface|null $extensionAttributes
     */
    public function __construct(
        string $escape = null,
        string $enclosure = null,
        string $delimiter = null,
        string $multipleValueSeparator = null,
        CsvFormatExtensionInterface $extensionAttributes = null
    ) {
        $this->escape = $escape;
        $this->enclosure = $enclosure;
        $this->delimiter = $delimiter;
        $this->multipleValueSeparator = $multipleValueSeparator;
        $this->extensionAttributes = $extensionAttributes;
    }

    /**
     * @inheritdoc
     */
    public function getEscape(): ?string
    {
        return $this->escape;
    }

    /**
     * @inheritdoc
     */
    public function getEnclosure(): ?string
    {
        return $this->enclosure;
    }

    /**
     * @inheritdoc
     */
    public function getDelimiter(): ?string
    {
        return $this->delimiter;
    }

    /**
     * @inheritdoc
     */
    public function getMultipleValueSeparator(): ?string
    {
        return $this->multipleValueSeparator;
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?CsvFormatExtensionInterface
    {
        return $this->extensionAttributes;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ImportMappingInterface
 */
interface ImportMappingInterface extends ExtensibleDataInterface
{
    public const SOURCE_NAME_PREFIX = 'source';
    public const TARGET_NAME_PREFIX = 'target';

    public const NAME = 'name';
    public const SOURCE_PATH = 'source_path';
    public const TARGET_PATH = 'target_path';
    public const SOURCE_VALUE = 'source_value';
    public const TARGET_VALUE = 'target_value';
    public const PROCESSING_RULES = 'processing_rules';

    /**
     * Retrieve name for internal use
     *
     * @return string
     */
    public function getName(): ?string;

    /**
     * Set name for internal use
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /** product.sku
     * Retrieve Source path to the value
     *
     * @return string|null
     */
    public function getSourcePath(): ?string;

    /**
     * Set Source path to the value
     *
     * @param string $sourcePath
     * @return void
     */
    public function setSourcePath(string $sourcePath): void;

    /**
     * product.sku_custom|null
     * Retrieve Target path to the value
     *
     * @return string|null
     */
    public function getTargetPath(): ?string;

    /**
     * Set Target path to the value
     *
     * @param string $targetPath
     * @return void
     */
    public function setTargetPath(string $targetPath): void;

    /**
     * Retrieve value from source_path without processing rules or static data
     * which was set manually to this field (static data will be rewrited by
     * data from source_path if exist)
     *
     * @return string|null
     */
    public function getSourceValue(): ?string;

    /**
     * Set data from source_path or some static data
     *
     * @param string $sourceValue
     * @return void
     */
    public function setSourceValue(string $sourceValue): void;

    /**
     * Retrieve value from target_path after processing rules or static data
     * which was set manually to this field (static data will be rewrited by
     * data from source_path if exist)
     *
     * @return string|null
     */
    public function getTargetValue(): ?string;

    /**
     * Set processed data or some static data to target_path
     *
     * @param string $targetValue
     * @return void
     */
    public function setTargetValue(string $targetValue): void;

    /**
     * Retrieve rules for processing attribute value, e.g. strtolower, trim
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleInterface[]|null
     */
    public function getProcessingRules(): ?array;

    /**
     * Set rules for processing attribute value, e.g. strtolower, trim
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleInterface[]|null $processingRules
     * @return void
     */
    public function setProcessingRules(?array $processingRules): void;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportMappingExtensionInterface|null
     */
    public function getExtensionAttributes(): ?ImportMappingExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportMappingExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\ImportServiceApi\Api\Data\ImportMappingExtensionInterface $extensionAttributes
    ): ImportMappingInterface;
}
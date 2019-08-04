<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection,PhpFullyQualifiedNameUsageInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\ImportServiceApi\Api\Data\ImportMappingInterface;

/**
 * Interface ImportConfigInterface
 */
interface ImportConfigInterface extends ExtensibleDataInterface
{
    public const IMPORT_STRATEGY = 'import_strategy';
    public const ALLOWED_ERROR_COUNT = 'allowed_error_count';
    public const VALIDATION_STRATEGY = 'validation_strategy';
    public const IMPORT_IMAGE_ARCHIVE = 'import_image_archive';
    public const IMPORT_IMAGES_FILE_DIR = 'import_images_file_dir';
    public const MAPPING = 'mapping';
    public const IMPORT_TYPE = 'import_type';

    /**
     * @return string
     */
    public function getImportType(): string;

    /**
     * @param string $importType
     *
     * @return void
     */
    public function setImportType(string $importType): void;

    /**
     * @return string
     */
    public function getImportStrategy(): string;

    /**
     * @param string $importStrategy
     *
     * @return void
     */
    public function setImportStrategy(string $importStrategy): void;

    /**
     * @return int
     */
    public function getAllowedErrorCount(): int;

    /**
     * @param int $allowedErrorCount
     *
     * @return void
     */
    public function setAllowedErrorCount(int $allowedErrorCount): void;

    /**
     * @return string
     */
    public function getValidationStrategy(): string;

    /**
     * @param string $validationStrategy
     *
     * @return void
     */
    public function setValidationStrategy(string $validationStrategy): void;

    /**
     * @return string
     */
    public function getImportImageArchive(): string;

    /**
     * @param string $importImageArchive
     *
     * @return void
     */
    public function setImportImageArchive(string $importImageArchive): void;

    /**
     * @return string
     */
    public function getImportImagesFileDir(): string;

    /**
     * @param string $importImagesFileDir
     *
     * @return void
     */
    public function setImportImagesFileDir(string $importImagesFileDir): void;

    /**
     * @return \Magento\ImportServiceApi\Api\Data\ImportMappingInterface[]|null
     */
    public function getMapping(): ?array;

    /**
     * @param \Magento\ImportServiceApi\Api\Data\ImportMappingInterface[]|null $importMapping
     */
    public function setMapping(?array $importMapping): void;

    /**
     * @return \Magento\ImportServiceApi\Api\Data\ImportConfigExtensionInterface|null
     */
    public function getExtensionAttributes(): ImportConfigExtensionInterface;

    /**
     * @param \Magento\ImportServiceApi\Api\Data\ImportConfigExtensionInterface $extension
     *
     * @return void
     */
    public function setExtensionAttributes(
        ImportConfigExtensionInterface $extensionAttributes
    ): void;
}

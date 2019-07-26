<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection,PhpFullyQualifiedNameUsageInspection
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ImportConfigInterface
 */
interface ImportConfigInterface extends ExtensibleDataInterface
{
    public const BEHAVIOUR = 'behaviour';
    public const ALLOWED_ERROR_COUNT = 'allowed_error_count';
    public const VALIDATION_STRATEGY = 'validation_strategy';
    public const IMPORT_IMAGE_ARCHIVE = 'import_image_archive';
    public const IMPORT_IMAGES_FILE_DIR = 'import_images_file_dir';

    /**
     * @return string
     */
    public function getBehaviour(): string;

    /**
     * @param string $behaviour
     *
     * @return void
     */
    public function setBehaviour(string $behaviour): void;

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
     * @return \Magento\ImportService\Api\Data\ImportConfigExtensionInterface
     */
    public function getExtensionAttributes(): \Magento\ImportService\Api\Data\ImportConfigExtensionInterface;

    /**
     * @param \Magento\ImportService\Api\Data\ImportConfigExtensionInterface $extensionAttributes
     *
     * @return void
     */
    public function setExtensionAttributes(
        \Magento\ImportService\Api\Data\ImportConfigExtensionInterface $extensionAttributes
    ): void;
}

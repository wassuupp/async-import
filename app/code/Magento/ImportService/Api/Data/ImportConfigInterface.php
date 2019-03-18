<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\ImportService\Api\Data\ImportConfigExtensionInterface;

/**
 * Interface ImportConfigInterface
 */
interface ImportConfigInterface extends ExtensibleDataInterface
{
    const PROFILE_UUID = 'profile_uuid';
    const BEHAVIOUR = 'behaviour';
    const IMPORT_IMAGE_ARCHIVE = 'import_image_archive';
    const IMPORT_IMAGES_FILE_DIR = 'import_images_file_dir';
    const ALLOWED_ERROR_COUNT = 'allowed_error_count';
    const VALIDATION_STRATEGY = 'validation_strategy';
    const EMPTY_ATTRIBUTE_VALUE_CONSTANT = 'empty_attribute_value_constant';
    const CSV_SEPARATOR = 'csv_separator';
    const CSV_ENCLOSURE = 'csv_enclosure';
    const CSV_DELIMITER = 'csv_delimiter';
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    /**
     * @return string
     */
    public function getProfileUuid(): string;

    /**
     * @param string $profileUuid
     * @return void
     */
    public function setProfileUuid(string $profileUuid): void;

    /**
     * @return string
     */
    public function getBehaviour(): string;

    /**
     * @param string $behaviour
     * @return void
     */
    public function setBehaviour(string $behaviour): void;

    /**
     * @return string
     */
    public function getImportImageArchive(): string;

    /**
     * @param string $importImageArchive
     * @return void
     */
    public function setImportImageArchive(string $importImageArchive): void;

    /**
     * @return string
     */
    public function getImportImagesFileDir(): string;

    /**
     * @param string $importImagesFileDir
     * @return void
     */
    public function setImportImagesFileDir(string $importImagesFileDir): void;

    /**
     * @return int
     */
    public function getAllowedErrorCount(): int;

    /**
     * @param int $allowedErrorCount
     * @return void
     */
    public function setAllowedErrorCount(int $allowedErrorCount): void;

    /**
     * @return string
     */
    public function getValidationStrategy(): string;

    /**
     * @param string $validationStrategy
     * @return void
     */
    public function setValidationStrategy(string $validationStrategy): void;

    /**
     * @return string
     */
    public function getEmptyAttributeValueConstant(): string;

    /**
     * @param string $emptyAttributeValueConstant
     * @return void
     */
    public function setEmptyAttributeValueConstant(string $emptyAttributeValueConstant): void;

    /**
     * @return string
     */
    public function getCsvSeparator(): string;

    /**
     * @param string $csvSeparator
     * @return void
     */
    public function setCsvSeparator(string $csvSeparator): void;

    /**
     * @return string
     */
    public function getCsvEnclosure(): string;

    /**
     * @param string $csvEnclosure
     * @return void
     */
    public function setCsvEnclosure(string $csvEnclosure): void;

    /**
     * @return string
     */
    public function getCsvDelimiter(): string;

    /**
     * @param string $csvDelimiter
     * @return void
     */
    public function setCsvDelimiter(string $csvDelimiter): void;

    /**
     * @return string
     */
    public function getMultipleValueSeparator(): string;

    /**
     * @param $multipleValueSeparator
     * @return void
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): void;

    /**
     * @return ImportConfigExtensionInterface
     */
    public function getExtensionAttributes(): ImportConfigExtensionInterface;

    /**
     * @param ImportConfigExtensionInterface $extension
     * @return void
     */
    public function setExtensionAttributes(ImportConfigExtensionInterface $extension): void;
}

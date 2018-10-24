<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportRest\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ImportParamsInterface extends ExtensibleDataInterface
{
    const BEHAVIOR = 'behavior';
    /**
     * Import source file.
     */
    const IMPORT_FILE = 'import_file';

    /**
     * Import image archive.
     */
    const IMG_ARCHIVE_FILE = 'import_image_archive';

    /**
     * Import images file directory.
     */
    const IMG_FILE_DIR = 'import_images_file_dir';

    /**
     * Allowed errors count field name
     */
    const ALLOWED_ERROR_COUNT = 'allowed_error_count';

    /**
     * Validation startegt field name
     */
    const VALIDATION_STRATEGY = 'validation_strategy';

    /**
     * Import field separator.
     */
    const SEPARATOR = 'separator';

    /**
     * Import multiple value separator.
     */
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    /**
     * Import empty attribute value constant.
     */
    const EMPTY_ATTRIBUTE_VALUE_CONSTANT = 'empty_attribute_value_constant';

    /**
     * Allow multiple values wrapping in double quotes for additional attributes.
     */
    const ENCLOSURE = 'enclosure';
    /**
     * default delimiter for several values in one cell as default for FIELD_FIELD_MULTIPLE_VALUE_SEPARATOR
     */
    const DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR = ',';

    /**
     * default empty attribute value constant
     */
    const DEFAULT_EMPTY_ATTRIBUTE_VALUE_CONSTANT = '__EMPTY__VALUE__';

    /**#@+
     * Import constants
     */
    const DEFAULT_SIZE = 50;
    const MAX_IMPORT_CHUNKS = 4;
    const IMPORT_HISTORY_DIR = 'import_history/';
    const IMPORT_DIR = 'import/';

    /**
     * @return string
     */
    public function getBehavior();

    /**
     * @param $behavior
     * @return string
     */
    public function setBehavior($behavior);

    /**
     * @return string
     */
    public function getImportFile();

    /**
     * @param $importFile
     * @return string
     */
    public function setImportFile($importFile);

    /**
     * @return string
     */
    public function getImportImageArchive();

    /**
     * @param $importImageArchive
     * @return string
     */
    public function setImportImageArchive($importImageArchive);

    /**
     * @return string
     */
    public function getImportImagesFileDir();

    /**
     * @param $importImagesFileDir
     * @return string
     */
    public function setImportImagesFileDir($importImagesFileDir);

    /**
     * @return integer
     */
    public function getAllowedErrorCount();

    /**
     * @param $allowedErrorCount
     * @return integer
     */
    public function setAllowedErrorCount($allowedErrorCount);

    /**
     * @return string
     */
    public function getValidationStrategy();

    /**
     * @param $validationStrategy
     * @return string
     */
    public function setValidationStrategy($validationStrategy);

    /**
     * @return string
     */
    public function getSeparator();

    /**
     * @param $separator
     * @return string
     */
    public function setSeparator($separator);

    /**
     * @return string
     */
    public function getEnclosure();

    /**
     * @param $enclosure
     * @return string
     */
    public function setEnclosure($enclosure);

    /**
     * @return string
     */
    public function getMultipleValueSeparator();

    /**
     * @param $multipleValueSeparator
     * @return string
     */
    public function setMultipleValueSeparator($multipleValueSeparator);

    /**
     * @return string
     */
    public function getEmptyAttributeValueConstant();

    /**
     * @param $emptyAttributeValueConstant
     * @return string
     */
    public function setEmptyAttributeValueConstant($emptyAttributeValueConstant);
}

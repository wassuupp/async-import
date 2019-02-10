<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source;

use Magento\Framework\File\Mime\Proxy as Mime;

/**
 * Class Validator
 */
class Validator
{
    /**
     * The expected mime types for imported files
     * @var array
     */
    const EXPECTED_MIME_TYPES = [
        'text/plain',
        'text/csv'
    ];

    /**
     * @var \Magento\Framework\File\Mime\Proxy
     */
    protected $mime;

    /**
     * @param Mime $mime
     */
    public function __construct(
        Mime $mime
    ) {
        $this->mime = $mime;
    }

    /**
     * @param \Magento\ImportService\Model\Source $source
     * @return array|null
     */
    public function validateRequest(\Magento\ImportService\Model\Source $source)
    {
        $errors = [];

        if (!$this->validateSourceType($source)) {
            $errors[] = $source::SOURCE_TYPE . ' cannot be empty';
        }

        if (!$this->validateImportData($source)) {
            $errors[] = $source::IMPORT_DATA . ' cannot be empty';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        return null;
    }

    /**
     * @param \Magento\ImportService\Model\Source $source
     * @return bool
     */
    public function validateSourceType(\Magento\ImportService\Model\Source $source)
    {
        if (!$source->getSourceType()) {
            return false;
        }

        return true;
    }

    /**
     * @param \Magento\ImportService\Model\Source $source
     * @return bool
     */
    public function validateImportData(\Magento\ImportService\Model\Source $source)
    {
        if (!$source->getImportData()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $absoluteFilePath
     * @return bool
     */
    public function validateMimeType(string $absoluteFilePath)
    {
        /** @var string $mimeType */
        $mimeType = $this->mime->getMimeType($absoluteFilePath);

        if (!in_array($mimeType, self::EXPECTED_MIME_TYPES)) {
            return false;
        }

        return true;
    }
}

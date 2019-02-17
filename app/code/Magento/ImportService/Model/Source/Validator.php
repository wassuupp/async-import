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
     * @var string[]
     */
    protected $allowedMimeTypes;

    /**
     * @var \Magento\Framework\File\Mime\Proxy
     */
    protected $mime;

    /**
     * @param string[] $allowedMimeTypes
     * @param Mime $mime
     */
    public function __construct(
        array $allowedMimeTypes,
        Mime $mime
    ) {
        $this->allowedMimeTypes = $allowedMimeTypes;
        $this->mime = $mime;
    }

    /**
     * @return string[]
     */
    public function getAllowedMimeTypes()
    {
        return $this->allowedMimeTypes;
    }

    /**
     * @param \Magento\ImportService\Model\Source $source
     * @return array|null
     */
    public function validateRequest(\Magento\ImportService\Model\Source $source)
    {
        $errors = [];

        if (!$this->validateSourceType($source)) {
            $errors[] = __('%1 cannot be empty', $source::SOURCE_TYPE);
        }

        if (!$this->validateImportData($source)) {
            $errors[] = __('%1 cannot be empty', $source::IMPORT_DATA);
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
    public function validateMimeTypeForLocalFile(string $absoluteFilePath)
    {
        /** @var string $mimeType */
        $mimeType = $this->mime->getMimeType($absoluteFilePath);

        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            return false;
        }

        return true;
    }
}

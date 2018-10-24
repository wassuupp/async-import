<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportRest\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface FileContentInterface extends ExtensibleDataInterface
{
    const BASE64_ENCODED_DATA = 'base64_encoded_data';
    const TYPE = 'type';
    const NAME = 'name';

    /**
     * Retrieve file data (base64 encoded content)
     *
     * @return string
     */
    public function getBase64EncodedData();

    /**
     * Set file data (base64 encoded content)
     *
     * @param string $data
     * @return $this
     */
    public function setBase64EncodedData($data);

    /**
     * Retrieve MIME type
     *
     * @return string
     */
    public function getType();

    /**
     * Set MIME type
     *
     * @param string $mimeType
     * @return $this
     */
    public function setType($mimeType);

    /**
     * Retrieve image name
     *
     * @return string
     */
    public function getName();

    /**
     * Set image name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);
}

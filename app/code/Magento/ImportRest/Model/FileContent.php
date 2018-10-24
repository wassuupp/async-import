<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportRest\Model;

use Magento\Framework\DataObject;
use Magento\ImportRest\Api\Data\FileContentInterface;

class FileContent extends DataObject implements FileContentInterface
{

    /**
     * @inheritDoc
     */
    public function getBase64EncodedData()
    {
        return $this->getData(self::BASE64_ENCODED_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setBase64EncodedData($data)
    {
        return $this->setData(self::BASE64_ENCODED_DATA, $data);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType($mimeType)
    {
        return $this->setData(self::TYPE, $mimeType);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
}

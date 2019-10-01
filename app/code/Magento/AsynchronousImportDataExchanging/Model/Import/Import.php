<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\Import;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportExtensionInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;

/**
 * @inheritdoc
 */
class Import implements ImportInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $importType;

    /**
     * @var string
     */
    private $importBehaviour;

    /**
     * @var ImportExtensionInterface|null
     */
    private $extensionAttributes;

    /**
     * @param string $importType
     * @param string $importBehaviour
     * @param string|null $uuid
     * @param ImportExtensionInterface|null $extensionAttributes
     */
    public function __construct(
        string $importType,
        string $importBehaviour,
        string $uuid = null,
        ImportExtensionInterface $extensionAttributes = null
    ) {
        $this->importType = $importType;
        $this->importBehaviour = $importBehaviour;
        $this->uuid = $uuid;
        $this->extensionAttributes = $extensionAttributes;
    }


    /**
     * @inheritdoc
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @inheritdoc
     */
    public function getImportType(): string
    {
        return $this->importType;
    }

    /**
     * @inheritdoc
     */
    public function getImportBehaviour(): string
    {
        return $this->importBehaviour;
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?ImportExtensionInterface
    {
        return $this->extensionAttributes;
    }
}

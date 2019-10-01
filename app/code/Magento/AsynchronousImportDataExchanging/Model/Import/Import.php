<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\Import;

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
     * @param string $importType
     * @param string $importBehaviour
     * @param string|null $uuid
     */
    public function __construct(
        string $importType,
        string $importBehaviour,
        string $uuid = null
    ) {
        $this->importType = $importType;
        $this->importBehaviour = $importBehaviour;
        $this->uuid = $uuid;
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
}

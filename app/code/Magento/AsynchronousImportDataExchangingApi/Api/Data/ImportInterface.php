<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangingApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Describes how to import data
 *
 * @api
 */
interface ImportInterface extends ExtensibleDataInterface
{
    public const UUID = 'uuid';
    public const IMPORT_TYPE = 'import_type';
    public const IMPORT_BEHAVIOUR = 'import_behaviour';

    /**
     * Get import uuid
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Get import type
     *
     * @return string
     */
    public function getImportType(): string;

    /**
     * Get import behaviour
     *
     * @return string
     */
    public function getImportBehaviour(): string;

    /**
     * Get existing extension attributes object
     *
     * Used fully qualified namespaces in annotations for proper work of extension interface/class code generation
     *
     * @return \Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportExtensionInterface|null
     */
    public function getExtensionAttributes(): ?ImportExtensionInterface;
}

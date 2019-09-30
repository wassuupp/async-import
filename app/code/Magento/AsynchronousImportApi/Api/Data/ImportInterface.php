<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

/**
 * Represents import request
 *
 * @api
 */
interface ImportInterface
{
    public const UUID = 'uuid';
    public const IMPORT_TYPE = 'import_type';
    public const IMPORT_BEHAVIOUR = 'import_behaviour';
    public const CONVERTING_RULES = 'converting_rules';

    /**
     * Get import uuid
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Get import type
     *
     * @return string|null
     */
    public function getImportType(): string;

    /**
     * Get import behaviour
     *
     * @return string|null
     */
    public function getImportBehaviour(): string;

    /**
     * Get converting rules
     *
     * @return \Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface[]
     */
    public function getConvertingRules(): array;
}

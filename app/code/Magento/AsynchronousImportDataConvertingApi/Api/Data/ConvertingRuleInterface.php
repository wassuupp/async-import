<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConvertingApi\Api\Data;

/**
 * Describes how to change data before import
 *
 * @api
 */
interface ConvertingRuleInterface
{
    public const IDENTIFIER = 'identifier';
    public const PARAMETERS = 'parameters';
    public const SORT = 'sort';
    public const APPLY_TO = 'apply_to';

    /**
     * Get rule identifier
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Get rule parameters
     *
     * @return string[]
     */
    public function getParameters(): array;

    /**
     * Get sort
     *
     * @return int
     */
    public function getSort(): int;

    /**
     * Get apply to
     *
     * @return string[]
     */
    public function getApplyTo(): array;
}

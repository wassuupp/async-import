<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */

declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

interface ImportProcessingRuleArgumentInterface
{
    public const VALUE = 'value';

    /**
     * Get argument value
     *
     * @return string|null
     */
    public function getValue(): ?string;

    /**
     * Set argument value
     *
     * @param string|null $value
     *
     * @return void
     */
    public function setValue(?string $value): void;
}

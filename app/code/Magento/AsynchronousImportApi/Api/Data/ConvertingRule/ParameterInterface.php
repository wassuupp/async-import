<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data\ConvertingRule;

/**
 * Represents parameter of the parameters data field of converting rule
 *
 * @api
 */
interface ParameterInterface
{
    /**
     * Get parameter name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get parameter value
     *
     * @return string[]
     */
    public function getValue(): array;
}

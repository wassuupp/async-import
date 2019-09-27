<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\ImportException;

/**
 * Responsible for converting import data. Represents one converting rule
 *
 * @see ConvertorRulesProcessorInterface
 * @api
 */
interface ConvertingRuleProcessorInterface
{
    /**
     * Responsible for converting import data. Represents one converting rule processor
     *
     * @param string[] $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return string[]
     * @throws ImportException
     */
    public function execute(
        array $importData,
        ConvertingRuleInterface $convertingRule
    ): array;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Api;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;

/**
 * Operation for applying converting rules to import data
 *
 * @api
 */
interface ApplyConvertingRulesInterface
{
    /**
     * Responsible for converting import data. Extension point for new data converting rules
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface[] $convertingRules
     * @return ImportDataInterface
     * @throws ApplyConvertingRulesException
     */
    public function execute(
        ImportDataInterface $importData,
        array $convertingRules
    ): ImportDataInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportConvertingRulesApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;

/**
 * Extension point for applying one converting rule to import data
 *
 * @api
 */
interface ApplyConvertingRuleInterface
{
    /**
     * Extension point for applying one converting rule to import data
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface $convertingRule
     * @return ImportDataInterface
     */
    public function execute(
        ImportDataInterface $importData,
        ConvertingRuleInterface $convertingRule
    ): ImportDataInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\ImportException;

/**
 * Responsible for converting import data. Extension point for new data converting rules
 *
 * @api
 */
interface ConvertingRulesProcessorInterface
{
    /**
     * Responsible for converting import data. Extension point for new data converting rules
     *
     * @param ImportDataInterface $importData
     * @param ConvertingRuleInterface[] $convertingRules
     * @return ImportDataInterface
     * @throws ImportException
     */
    public function execute(
        ImportDataInterface $importData,
        array $convertingRules
    ): ImportDataInterface;
}

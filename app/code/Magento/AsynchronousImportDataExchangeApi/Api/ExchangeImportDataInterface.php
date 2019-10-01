<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangeApi\Api;

use Magento\AsynchronousImportDataExchangeApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportDataExchangeApi\Api\Data\ImportInterface;

/**
 * Operation for exchanging import data with destination instance
 *
 * @api
 */
interface ExchangeImportDataInterface
{
    /**
     * Operation for exchanging import data with destination instance
     *
     * @param ImportInterface $import
     * @param ImportDataInterface $importData
     * @return string
     * @throws ImportDataExchangeException
     */
    public function execute(ImportInterface $import, ImportDataInterface $importData): string;
}

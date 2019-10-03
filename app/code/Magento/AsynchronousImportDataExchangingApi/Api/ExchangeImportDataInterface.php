<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangingApi\Api;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\Framework\Validation\ValidationException;

/**
 * Operation for exchanging import data with destination instance. Uses differect strategies for data import
 *
 * @api
 */
interface ExchangeImportDataInterface
{
    /**
     * Operation for exchanging import data with destination instance
     *
     * @param ImportInterface $import
     * @param array $importData
     * @return void
     * @throws ValidationException
     * @throws ImportDataExchangeException
     */
    public function execute(ImportInterface $import, array $importData): void;
}

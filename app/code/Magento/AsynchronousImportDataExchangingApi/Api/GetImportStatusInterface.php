<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangingApi\Api;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportStatusInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Get import status operation
 *
 * @api
 */
interface GetImportStatusInterface
{
    /**
     * Get import status operation
     *
     * @param string $uuid
     * @return ImportStatusInterface
     * @throws NotFoundException
     */
    public function execute(string $uuid): ImportStatusInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection,PhpFullyQualifiedNameUsageInspection
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\ImportStatusResponseInterface;

/**
 * Class ImportStatus
 */
interface ImportStatusInterface
{
    /**
     * Get import source status.
     *
     * @param string $uuid
     *
     * @return \Magento\ImportService\Api\Data\ImportStatusResponseInterface
     */
    public function execute(string $uuid): ImportStatusResponseInterface;
}

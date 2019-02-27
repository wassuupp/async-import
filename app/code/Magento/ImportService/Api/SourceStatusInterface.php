<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

/**
 * Class SourceStatus
 */
interface SourceStatusInterface
{
    /**
     * Get source status.
     *
     * @param string $uuid
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseInterface
     */
    public function execute(string $uuid);
}

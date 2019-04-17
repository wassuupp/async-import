<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Class SourceUpdate
 */
interface SourceUpdateInterface
{
    /**
     * Update source.
     *
     * @param string $sourceType
     * @param string $uuid
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return \Magento\ImportService\Api\Data\SourceUpdateResponseInterface
     */
    public function execute(string $sourceType, string $uuid, SourceInterface $source);
}

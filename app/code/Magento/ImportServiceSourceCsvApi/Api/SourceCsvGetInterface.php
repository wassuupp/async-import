<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsvApi\Api;

/**
 * Class SourceCsvGetInterface
 */
interface SourceCsvGetInterface
{
    /**
     * Get CSV Source By UUID
     *
     * @param string $uuid
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface $source
     */
    public function execute(string $uuid);
}

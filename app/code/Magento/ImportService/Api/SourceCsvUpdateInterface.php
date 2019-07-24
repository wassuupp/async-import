<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceCsvInterface;

/**
 * Class SourceCsvUpdateInterface
 */
interface SourceCsvUpdateInterface
{
    /**
     * Update source.
     *
     * @param string $uuid
     * @param \Magento\ImportService\Api\Data\SourceCsvInterface $sourceInput
     * @return \Magento\ImportService\Api\Data\SourceUploadResponseInterface
     */
    public function execute(string $uuid, SourceCsvInterface $sourceInput);
}

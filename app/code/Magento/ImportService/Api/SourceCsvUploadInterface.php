<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceCsvInterface;

/**
 * Class SourceCsvUploadInterface
 */
interface SourceCsvUploadInterface
{
    /**
     * Upload source.
     *
     * @param \Magento\ImportService\Api\Data\SourceCsvInterface $source
     * @return \Magento\ImportService\Api\Data\SourceUploadResponseInterface
     */
    public function execute(SourceCsvInterface $source);
}

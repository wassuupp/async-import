<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api;

use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;

/**
 * ImportStartInterface interface
 */
interface ImportStartInterface
{
    /**
     * Start import
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportConfigInterface $importConfig
     * @return \Magento\ImportServiceApi\Api\Data\ImportStartResponseInterface
     */
    public function execute(ImportConfigInterface $importConfig);
}

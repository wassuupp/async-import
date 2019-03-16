<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\ImportConfigInterface;

/**
 * ImportStartInterface interface
 */
interface ImportStartInterface
{
    public function execute(ImportConfigInterface $importConfig);
}

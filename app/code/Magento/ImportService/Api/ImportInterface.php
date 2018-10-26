<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceDataInterface;

/**
 * Class ImportProcessor
 *
 * @package Magento\ImportService\Model
 */
interface ImportInterface
{

    /**
     * Run import.
     *
     * @param \Magento\ImportService\Api\Data\SourceDataInterface $sourceData
     * @return \Magento\ImportService\Api\Data\ImportResponseInterface
     */
    public function import(SourceDataInterface $sourceData);
}

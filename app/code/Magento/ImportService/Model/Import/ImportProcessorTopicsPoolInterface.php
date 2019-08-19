<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;

/**
 *  ImportProcessorsPoolInterface
 */
interface ImportProcessorTopicsPoolInterface
{

    public function getTopic(ImportConfigInterface $importConfig): string;

}

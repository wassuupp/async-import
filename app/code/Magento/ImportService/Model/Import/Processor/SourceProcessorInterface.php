<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use \Magento\ImportService\Api\Data\SourceDataInterface;

/**
 *  Request processor interface
 */
interface SourceProcessorInterface
{
    /**
     * @param SourceDataInterface $sourceData
     * @throws AuthorizationException
     * @throws InputException
     * @throws Exception
     * @return SourceDataInterface
     */
    public function processUpload(SourceDataInterface $sourceData);

}

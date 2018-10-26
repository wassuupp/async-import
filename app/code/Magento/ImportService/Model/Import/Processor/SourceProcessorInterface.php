<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

/**
 *  Request processor interface
 */
interface SourceProcessorInterface
{
    /**
     * Executes the logic to process the request
     *
     * @param \Magento\ImportService\Api\Data\SourceDataInterface $sourceData
     * @return void
     * @throws \Magento\Framework\Exception\AuthorizationException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function processUpload(\Magento\ImportService\Api\Data\SourceDataInterface $sourceData);

}

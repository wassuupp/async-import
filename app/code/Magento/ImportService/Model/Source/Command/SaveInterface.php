<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\ImportService\Api\Data\SourceCsvInterface;

/**
 * Save source data command
 *
 * Separate command interface to which Repository proxies initial Save call
 *
 * @see \Magento\ImportService\Api\SourceCsvRepositoryInterface
 */
interface SaveInterface
{
    /**
     * Save source data
     *
     * @param SourceCsvInterface $source
     * @return SourceCsvInterface
     * @throws CouldNotSaveException
     */
    public function execute(SourceCsvInterface $source): SourceCsvInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 * Save source data command
 *
 * Separate command interface to which Repository proxies initial Save call
 *
 * @see \Magento\ImportServiceApi\Api\SourceRepositoryInterface
 */
interface SaveInterface
{
    /**
     * Save source data
     *
     * @param SourceBuilderInterface $source
     *
     * @return SourceBuilderInterface
     * @throws CouldNotSaveException
     */
    public function execute(SourceBuilderInterface $source): SourceBuilderInterface;
}

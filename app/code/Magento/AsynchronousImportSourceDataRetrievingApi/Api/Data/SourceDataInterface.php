<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data;

/**
 * Represents retrieved source data (result of retrieving operation)
 *
 * @api
 */
interface SourceDataInterface extends \IteratorAggregate
{
    public const ITERATOR = 'iterator';
}

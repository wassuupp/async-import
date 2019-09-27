<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api\Data;

/**
 * Represents source data retrieving result
 *
 * @api
 */
interface RetrievingSourceDataResultInterface
{
    public const FILE = 'file';

    /**
     * Get file
     *
     * @return string|null
     */
    public function getFile(): ?string;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api\Data;

/**
 * Represents source data retrieving request
 *
 * @api
 */
interface SourceDataInterface
{
    public const SOURCE_TYPE = 'source_type';
    public const SOURCE_DATA = 'source_data';
    public const SOURCE_DATA_FORMAT = 'source_data_format';

    /**
     * Get source type
     *
     * @return string
     */
    public function getSourceType(): string;

    /**
     * Get source data
     *
     * @return string
     */
    public function getSourceData(): string;

    /**
     * Get source data format
     *
     * @return string
     */
    public function getSourceDataFormat(): string;
}

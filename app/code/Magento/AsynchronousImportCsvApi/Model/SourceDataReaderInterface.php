<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterface;

/**
 * Extension point for reading (parsing) source data based on CSV format
 *
 * @api
 */
interface SourceDataReaderInterface
{
    /**
     * Extension point for reading (parsing) source data based on CSV format
     *
     * @param SourceDataInterface $sourceData
     * @param CsvFormatInterface|null $csvFormat
     * @return ImportDataInterface
     */
    public function execute(SourceDataInterface $sourceData, CsvFormatInterface $csvFormat = null): ImportDataInterface;
}

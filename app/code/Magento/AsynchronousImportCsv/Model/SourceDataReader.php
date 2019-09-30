<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterfaceFactory;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportCsvApi\Model\SourceDataReaderInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterface;

/**
 * @inheritdoc
 */
class SourceDataReader implements SourceDataReaderInterface
{
    /**
     * @var ImportDataInterfaceFactory
     */
    private $importDataFactory;

    /**
     * @param ImportDataInterfaceFactory $importDataFactory
     */
    public function __construct(
        ImportDataInterfaceFactory $importDataFactory
    ) {
        $this->importDataFactory = $importDataFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData, CsvFormatInterface $csvFormat = null): ImportDataInterface
    {
        $parsedData = [];
        foreach ($sourceData->getData() as $row) {
            $parsedData[] = str_getcsv($row);
        }
        $importData = $this->importDataFactory->create(['data' => $parsedData]);
        return $importData;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportCsvApi\Api\StartImportInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\RetrieveSourceDataInterface;

/**
 * @inheritdoc
 */
class StartImport implements StartImportInterface
{
    /**
     * @var RetrieveSourceDataInterface
     */
    private $retrieveSourceData;

    /**
     * @param RetrieveSourceDataInterface $retrieveSourceData
     */
    public function __construct(RetrieveSourceDataInterface $retrieveSourceData)
    {
        $this->retrieveSourceData = $retrieveSourceData;
    }

    /**
     * @inheritdoc
     */
    public function execute(
        SourceInterface $source,
        ImportInterface $import,
        string $uuid = null,
        CsvFormatInterface $format = null
    ): string {
        $this->retrieveSourceData->execute($source);

        return $uuid;
    }
}

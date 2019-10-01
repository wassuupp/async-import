<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterfaceFactory;
use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportCsvApi\Api\StartImportInterface;
use Magento\AsynchronousImportCsvApi\Model\DataParserInterface;
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
     * @var DataParserInterface
     */
    private $dataParser;

    /**
     * @var ImportDataInterfaceFactory
     */
    private $importDataFactory;

    /**
     * @var ApplyConvertingRulesInterface
     */
    private $applyConvertingRules;

    /**
     * @param RetrieveSourceDataInterface $retrieveSourceData
     * @param DataParserInterface $dataParser
     * @param ImportDataInterfaceFactory $importDataFactory
     * @param ApplyConvertingRulesInterface $applyConvertingRules
     */
    public function __construct(
        RetrieveSourceDataInterface $retrieveSourceData,
        DataParserInterface $dataParser,
        ImportDataInterfaceFactory $importDataFactory,
        ApplyConvertingRulesInterface $applyConvertingRules
    ) {
        $this->retrieveSourceData = $retrieveSourceData;
        $this->dataParser = $dataParser;
        $this->importDataFactory = $importDataFactory;
        $this->applyConvertingRules = $applyConvertingRules;
    }

    /**
     * @inheritdoc
     */
    public function execute(
        SourceInterface $source,
        ImportInterface $import,
        string $uuid = null,
        CsvFormatInterface $format = null,
        array $convertingRules = []
    ): string {
        $sourceData = $this->retrieveSourceData->execute($source);

        foreach ($sourceData as $batch) {
            $csvData = $this->dataParser->execute($batch, $format);
            $importData = $this->importDataFactory->create(['data' => $csvData]);
            $this->applyConvertingRules->execute($importData, $convertingRules);
        }
        return 'UID';
    }
}

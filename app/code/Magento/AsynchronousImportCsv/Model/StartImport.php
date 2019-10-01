<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportCsvApi\Api\StartImportInterface;
use Magento\AsynchronousImportCsvApi\Model\DataParserInterface;
use Magento\AsynchronousImportDataExchangeApi\Api\Data\ImportInterface;
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
     * @var ApplyConvertingRulesInterface
     */
    private $applyConvertingRules;

    /**
     * @param RetrieveSourceDataInterface $retrieveSourceData
     * @param DataParserInterface $dataParser
     * @param ApplyConvertingRulesInterface $applyConvertingRules
     */
    public function __construct(
        RetrieveSourceDataInterface $retrieveSourceData,
        DataParserInterface $dataParser,
        ApplyConvertingRulesInterface $applyConvertingRules
    ) {
        $this->retrieveSourceData = $retrieveSourceData;
        $this->dataParser = $dataParser;
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
            $importData = $this->dataParser->execute($batch, $format);
            $this->applyConvertingRules->execute($importData, $convertingRules);
        }
        return 'UID';
    }
}

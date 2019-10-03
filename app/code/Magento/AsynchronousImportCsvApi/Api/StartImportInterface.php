<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api;

use Magento\AsynchronousImportDataConvertingApi\Api\ApplyConvertingRulesException;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ImportDataExchangeException;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;
use Magento\Framework\Validation\ValidationException;

/**
 * Start import operation
 *
 * @api
 */
interface StartImportInterface
{
    /**
     * Start import operation
     *
     * @param SourceInterface $source
     * @param ImportInterface $import
     * @param CsvFormatInterface|null $format
     * @param ConvertingRuleInterface[] $convertingRules
     * @return string
     * @throws ValidationException
     * @throws SourceDataRetrievingException
     * @throws ApplyConvertingRulesException
     * @throws ImportDataExchangeException
     */
    public function execute(
        SourceInterface $source,
        ImportInterface $import,
        CsvFormatInterface $format = null,
        array $convertingRules = []
    ): string;
}

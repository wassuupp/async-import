<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportConvertingRulesApi\Api\ApplyConvertingRulesException;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
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
     * @param string|null $uuid
     * @param CsvFormatInterface|null $format
     * @param \Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface[] $convertingRules
     * @return string
     * @throws ValidationException
     * @throws SourceDataRetrievingException
     * @throws ApplyConvertingRulesException
     */
    public function execute(
        SourceInterface $source,
        ImportInterface $import,
        string $uuid = null,
        CsvFormatInterface $format = null,
        array $convertingRules = []
    ): string;
}

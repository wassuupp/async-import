<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportCsvApi\Api\UpdateCsvSourceFormatInterface;

/**
 * @inheritdoc
 */
class UpdateCsvSourceFormat implements UpdateCsvSourceFormatInterface
{
    /**
     * @inheritdoc
     */
    public function execute(string $uuid, CsvFormatInterface $format): void
    {
        // phpcs:ignore Magento2.CodeAnalysis.EmptyBlock
        // TODO:
        // $sourceToUpdate->getSourceType() !== CsvSourceCreateInterface::CSV_SOURCE_TYPE
    }
}

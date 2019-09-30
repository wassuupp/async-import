<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportCsvApi\Model\DataParserInterface;

/**
 * @inheritdoc
 */
class DataParser implements DataParserInterface
{
    /**
     * @inheritdoc
     */
    public function execute(array $data, CsvFormatInterface $csvFormat = null): array
    {
        $parsedData = array_map('str_getcsv', $data);
        return $parsedData;
    }
}

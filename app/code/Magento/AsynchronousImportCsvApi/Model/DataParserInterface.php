<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Model;

use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;

/**
 * Extension point for data parsing (based on passed CSV format)
 *
 * @api
 */
interface DataParserInterface
{
    /**
     * Extension point for data parsing (based on passed CSV format)
     *
     * @param array $data
     * @param CsvFormatInterface|null $csvFormat
     * @return array
     */
    public function execute(array $data, CsvFormatInterface $csvFormat = null): array;
}

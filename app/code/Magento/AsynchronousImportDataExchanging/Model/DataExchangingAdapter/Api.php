<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\DataExchangingAdapter;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterInterface;

/**
 * Operation for exchanging import data with destination instance. Uses differect strategies for data import
 *
 * @api
 */
class Api implements ExchangeAdapterInterface
{

    public function __construct(
        array $exchangingProperties = []
    ) {
        $this->exchangingProperties = $exchangingProperties;
    }


    public function execute(ImportInterface $import, array $importData): void{

        echo "do Export via API here";
        var_dump($this->exchangingProperties);
        exit;

    }

}
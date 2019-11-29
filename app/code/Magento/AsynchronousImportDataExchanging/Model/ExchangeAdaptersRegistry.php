<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\Framework\Validation\ValidationException;

/**
 * Operation for exchanging import data with destination instance. Uses differect strategies for data import
 *
 * @api
 */
class ExchangeAdaptersRegistry
{

    public function __construct(
        array $exchangeAdapters
    ) {
        $this->exchangeAdapters = $exchangeAdapters;
    }

    public function get(){

        /**
         * @TODO Get Config values
         */
        $adapters = "api";
        return $this->exchangeAdapters[$adapters];

    }
}

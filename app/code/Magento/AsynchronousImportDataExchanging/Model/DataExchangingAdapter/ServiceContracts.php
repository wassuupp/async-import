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
 * Data exchange adapter for processing requests based on Service contracts.
 * So module is installed as part of Magento monolyth
 *
 * @api
 */
class ServiceContracts implements ExchangeAdapterInterface
{

    /**
     * ServiceContracts constructor.
     * @param array $exchangingProperties
     */
    public function __construct(
        array $exchangingProperties
    ) {
        $this->exchangingProperties = $exchangingProperties;
    }

    /**
     * Execute
     *
     * @param ImportInterface $import
     * @param array $importData
     */
    public function execute(ImportInterface $import, array $importData): void{

        echo "do Export via SC here";
        var_dump($this->exchangingProperties);
        exit;

    }

}
<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportAdvancedPricing\Model\DataExchangingStrategy\AdvancedPricing\Behaviour;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Model\ExchangeDataBehaviourInterface;

/**
 * @inheritdoc
 */
class Delete implements ExchangeDataBehaviourInterface
{

    public function execute(ImportInterface $import, array $importData): void
    {
        exit;
        // TODO: Implement execute() method.
    }

}
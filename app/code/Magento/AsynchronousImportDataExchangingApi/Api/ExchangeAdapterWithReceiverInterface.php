<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangingApi\Api;

interface ExchangeAdapterWithReceiverInterface extends ExchangeAdapterInterface
{
    /**
     * @param $remoteReceiver \Magento\AsynchronousImportDataExchangingApi\Api\Data\RemoteReceiverInterface
     * @return $this
     */
    public function setRemoteReceiver($remoteReceiver);
}

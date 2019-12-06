<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchangingApi\Api\Data;

/**
 * Interface RemoteReceiverInterface
 * @package Magento\AsynchronousImportDataExchanging\Api\Data
 */
interface RemoteReceiverInterface
{
    /** @var string  */
    const INTEGRATION_TOKEN = 'integration_token';

    /** @var string  */
    const BASE_URL = 'base_url';

    /**
     * @param string $integrationToken
     * @return $this
     */
    public function setIntegrationToken($integrationToken);

    /**
     * @return string
     */
    public function getIntegrationToken();

    /**
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl);

    /**
     * @return string
     */
    public function getBaseUrl();
}

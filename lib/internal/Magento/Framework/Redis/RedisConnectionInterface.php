<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis;

/**
 * Provide preconfigured connection to Credis client
 */
interface RedisConnectionInterface
{
    /**
     * @return \Credis_Client
     */
    public function getClient(): \Credis_Client;
}

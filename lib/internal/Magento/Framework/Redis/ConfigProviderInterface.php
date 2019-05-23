<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis;

interface ConfigProviderInterface
{
    /**
     * @return ConfigInterface
     */
    public function execute(): ConfigInterface;
}

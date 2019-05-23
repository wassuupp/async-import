<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Framework\Redis;

/**
 * Access all Redis configuration
 */
interface ConfigInterface
{
    /**
     * @return string|null
     */
    public function getHost(): ?string;

    /**
     * @return int|null
     */
    public function getPort(): ?int;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;

    /**
     * @return int
     */
    public function getDatabase(): int;

    /**
     * @return int|null
     */
    public function getTimeout(): ?int;

    /**
     * @return string
     */
    public function getPersistent(): string;
}

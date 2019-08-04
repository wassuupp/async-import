<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

/**
 * Interface ImportStartResponseInterface
 */
interface ImportStartResponseInterface
{
    public const UUID = 'uuid';
    public const STATUS = 'status';
    public const ERROR = 'error';
    public const STATUS_RUNNING = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAIL = 'fail';

    /**
     * Get UUID
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Set UUID
     *
     * @param string $uuid
     *
     * @return void
     */
    public function setUuid(string $uuid): void;

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): ?string;

    /**
     * Set status
     *
     * @param string $status
     *
     * @return void
     */
    public function setStatus(string $status): void;

    /**
     * Get error
     *
     * @return string
     */
    public function getError(): ?string;

    /**
     * Set error
     *
     * @param string $error
     *
     * @return void
     */
    public function setError(string $error): void;
}

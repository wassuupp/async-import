<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface SourceUpdateResponseInterface
 */
interface SourceUpdateResponseInterface
{
    const STATUS = 'status';
    const MESSAGE = 'message';

    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';

    /**
     * Get file status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage();

    /**
     * @param string $status
     * @return mixed
     */
    public function setStatus(string $status);

    /**
     * @param string $message
     * @return mixed
     */
    public function setMessage(string $message);
}

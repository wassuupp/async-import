<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\AsynchronousOperations\Model;

use Magento\AsynchronousOperations\Model\BulkStorage\Redis;

/**
 * Class BulkStorageFactory
 */
class BulkStorageFactory
{
    /** @var BulkStorageInterface */
    private $storageEngine;

    /**
     * BulkStorageFactory constructor.
     *
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->storageEngine = $redis;
    }

    /**
     * Return bulk storage engine.
     *
     * @return BulkStorageInterface
     */
    public function create(): BulkStorageInterface
    {
        return $this->storageEngine;
    }
}
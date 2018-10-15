<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\AsynchronousOperations\Model;

use \Magento\AsynchronousOperations\Api\Data\BulkSummaryInterface;
use \Magento\AsynchronousOperations\Api\Data\OperationInterface;

/**
 * Class BulkStorageInterface
 */
interface BulkStorageInterface
{
    /**
     * Save bulk summary using available storage engine.
     *
     * @param BulkSummaryInterface $bulkSummary
     *
     * @return BulkSummaryInterface
     */
    public function saveBulk(BulkSummaryInterface $bulkSummary): BulkSummaryInterface;

    /**
     * Save bulk operation.
     *
     * @param OperationInterface $operation
     *
     * @return OperationInterface
     */
    public function saveOperation(OperationInterface $operation): OperationInterface;

    /**
     * Find failed operations available for retry.
     *
     * @param array  $errorCodes
     * @param string $bulkUuid
     *
     * @return OperationInterface[]
     */
    public function findRetriablyFailedOperations(array $errorCodes, string $bulkUuid): array;

    /**
     * Delete bulk operation.
     *
     * @param OperationInterface $operation
     *
     * @return bool
     */
    public function deleteOperation(OperationInterface $operation): bool;

    /**
     * Delete bulk summary.
     *
     * @param BulkSummaryInterface $bulkSummary
     *
     * @return bool
     */
    public function deleteBulk(BulkSummaryInterface $bulkSummary): bool;

    /**
     * Start transaction.
     */
    public function beginTransaction(): void;

    /**
     * Commit transaction.
     */
    public function commit(): void;

    /**
     * Rollback/discard transaction.
     */
    public function rollback(): void;
}

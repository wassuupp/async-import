<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\AsynchronousOperations\Model;

use Magento\AsynchronousOperations\Api\Data\BulkSummaryInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class BulkSummarySerializer
 */
class BulkSummarySerializer
{
    /**
     * @var Json
     */
    private $serializer;

    public function __construct(Json $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Serialize bulk summary object into JSON.
     *
     * @param BulkSummaryInterface $bulkSummary
     *
     * @return string
     */
    public function serialize(BulkSummaryInterface $bulkSummary): string
    {
        return $this->serializer->serialize($this->getSerializableData($bulkSummary));
    }

    /**
     * Unserialize bulk summary object from JSON.
     *
     * @param string $json
     *
     * @return BulkSummaryInterface
     */
    public function unserialize(string $json): BulkSummaryInterface
    {
        return new BulkSummary($this->serializer->unserialize($json));
    }

    /**
     * Get data for serialize().
     *
     * @param BulkSummaryInterface $bulkSummary
     *
     * @return array
     */
    protected function getSerializableData(BulkSummaryInterface $bulkSummary): array
    {
        return [
            'user_id'         => $bulkSummary->getUserId(),
            'description'     => $bulkSummary->getDescription(),
            'operation_count' => $bulkSummary->getOperationCount(),
            'start_time'      => $bulkSummary->getStartTime(),
        ];
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Class SourceStatusResponseItem
 */
interface SourceStatusResponseItemInterface
{
    const UUID = 'uuid';
    const STATUS = 'status';
    const SERIALIZED_DATA = 'serialized_data';
    const RESULT_SERIALIZED_DATA = 'result_serialized_data';
    const ERROR_CODE = 'error_code';
    const RESULT_MESSAGE = 'result_message';

    /**
     * Get uuid
     *
     * @return int|null
     */
    public function getUuid();

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Get serialized data
     *
     * @return string|null
     */
    public function getSerializedData();

    /**
     * Get serialized data result
     *
     * @return string|null
     */
    public function getResultSerializedData();

    /**
     * Get error code
     *
     * @return string|null
     */
    public function getErrorCode();

    /**
     * Get result message
     *
     * @return string|null
     */
    public function getResultMessage();

    /**
     * @param $uuid
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface
     */
    public function setUuid($uuid);

    /**
     * @param $status
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface
     */
    public function setStatus($status);

    /**
     * @param $serializedData
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface
     */
    public function setSerializedData($serializedData);

    /**
     * @param $resultSerializedData
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface
     */
    public function setResultSerializedData($resultSerializedData);

    /**
     * @param $errorCode
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface
     */
    public function setErrorCode($errorCode);

    /**
     * @param $resultMessage
     * @return \Magento\ImportService\Api\Data\SourceStatusResponseItemInterface
     */
    public function setResultMessage($resultMessage);
}

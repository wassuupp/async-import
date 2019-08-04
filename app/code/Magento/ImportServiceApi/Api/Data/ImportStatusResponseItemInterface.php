<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

/**
 * Class ImportStatusResponseItem
 */
interface ImportStatusResponseItemInterface
{
    public const UUID = 'uuid';
    public const STATUS = 'status';
    public const SERIALIZED_DATA = 'serialized_data';
    public const RESULT_SERIALIZED_DATA = 'result_serialized_data';
    public const ERROR_CODE = 'error_code';
    public const RESULT_MESSAGE = 'result_message';

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): string;

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get serialized data
     *
     * @return string
     */
    public function getSerializedData(): string;

    /**
     * Get serialized data result
     *
     * @return string
     */
    public function getResultSerializedData(): string;

    /**
     * Get error code
     *
     * @return string|null
     */
    public function getErrorCode(): ?string;

    /**
     * Get result message
     *
     * @return string
     */
    public function getResultMessage(): string;

    /**
     * Set uuid
     *
     * @param string  $uuid
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface
     */
    public function setUuid(string $uuid): ImportStatusResponseItemInterface;

    /**
     * Set imported status
     *
     * @param string $status
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface
     */
    public function setStatus(string $status): ImportStatusResponseItemInterface;

    /**
     * Set serialized data
     *
     * @param string $serializedData
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface
     */
    public function setSerializedData(string $serializedData): ImportStatusResponseItemInterface;

    /**
     * Set serialized result data
     *
     * @param string $resultSerializedData
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface
     */
    public function setResultSerializedData(string $resultSerializedData): ImportStatusResponseItemInterface;

    /**
     * Set error code if occured
     *
     * @param string $errorCode
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface
     */
    public function setErrorCode(string $errorCode): ImportStatusResponseItemInterface;

    /**
     * Set result message for process
     *
     * @param string $resultMessage
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportStatusResponseItemInterface
     */
    public function setResultMessage(string $resultMessage): ImportStatusResponseItemInterface;
}

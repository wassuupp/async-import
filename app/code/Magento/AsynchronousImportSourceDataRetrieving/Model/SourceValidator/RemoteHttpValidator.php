<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model\SourceValidator;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\SourceValidatorInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy\RemoteHttp;

/**
 * @inheritdoc
 */
class RemoteHttpValidator implements SourceValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(ValidationResultFactory $validationResultFactory)
    {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceInterface $source): ValidationResult
    {
        $errors = [];
        if ($source->getSourceType() !== RemoteHttp::REMOTE_HTTP_STRATEGY_NAME) {
            return $this->validationResultFactory->create(['errors' => $errors]);
        }

        $sourceDefinition = (string)$source->getSourceDefinition();

        if (!preg_match('%^http://.+$%', $sourceDefinition)
            || !filter_var($sourceDefinition, FILTER_VALIDATE_URL)
        ) {
            $errors[] = __(
                'Invalid "%field". Remote http data string is invalid.',
                ['field' => SourceInterface::SOURCE_DEFINITION]
            );
        } else {
            $errors = $this->validateSourceUrl($sourceDefinition, $source->getSourceDataFormat());
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }

    /**
     * Validate remote source url and mime type
     *
     * @param string $url
     * @param string $sourceDataFormat
     * @return array
     */
    private function validateSourceUrl(string $url, string $sourceDataFormat): array
    {
        $errors = [];
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $headers = array_change_key_case(get_headers($url, 1), CASE_LOWER);
        $status = $headers[0];
        /* Handling 301 or 302 redirection */
        if (isset($headers[1]) && preg_match('/30[12]/', $status)) {
            $status = $headers[1];
        }
        if (strpos($status, '200 OK') === false) {
            $errors[] = __(
                'Invalid "%field". Remote http source file unavailable.',
                ['field' => SourceInterface::SOURCE_DEFINITION]
            );
        } elseif (!isset($headers['content-type'])
            || (strpos($headers['content-type'], $sourceDataFormat) === false)
        ) {
            $errors[] = __(
                'Invalid "%field". Remote http source file has incorrect mime type.',
                ['field' => SourceInterface::SOURCE_DATA_FORMAT]
            );
        }
        return $errors;
    }
}

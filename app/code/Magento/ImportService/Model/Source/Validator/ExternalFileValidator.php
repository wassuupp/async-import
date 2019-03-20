<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\Framework\Filesystem\Driver\Http\Proxy as Http;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * Class ExternalFileValidator
 */
class ExternalFileValidator implements ValidatorInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Driver\Http
     */
    private $httpDriver;

    /**
     * @var SourceTypePool
     */
    private $sourceTypePool;

    /**
     * @param Http $httpDriver
     * @param SourceTypePool $sourceTypePool
     */
    public function __construct(
        Http $httpDriver,
        SourceTypePool $sourceTypePool
    ) {
        $this->httpDriver = $httpDriver;
        $this->sourceTypePool = $sourceTypePool;
    }

    /**
     * return error messages in array
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return []
     */
    public function validate(SourceInterface $source)
    {
        $errors = [];

        $externalSourceUrl = preg_replace("(^https?://)", "", $source->getImportData());

        /** check for file exists */
        if(!$this->httpDriver->isExists($externalSourceUrl)) {
            $errors[] = __('Remote file %1 does not exist.', $source->getImportData());
        }

        /** @var array $stat */
        $stat = $this->httpDriver->stat($externalSourceUrl);
        if (!isset($stat['type']) || !in_array($stat['type'], $this->sourceTypePool->getAllowedMimeTypes())) {
            $errors[] = __('Invalid mime type, expected is one of: %1', implode(", ", $this->sourceTypePool->getAllowedMimeTypes()));
        }

        return $errors;
    }
}

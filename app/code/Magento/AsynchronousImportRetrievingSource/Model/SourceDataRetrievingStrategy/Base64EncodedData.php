<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataRetrievingStrategy;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;
use Magento\Framework\Validation\ValidationException;

/**
 * Base64 encoded data strategy for retrieving source data
 */
class Base64EncodedData implements RetrieveSourceDataStrategyInterface
{
    /**
     * @var SourceDataValidatorInterface
     */
    private $sourceDataValidator;

    /**
     * @param SourceDataValidatorInterface $sourceDataValidator
     */
    public function __construct(
        SourceDataValidatorInterface $sourceDataValidator
    ) {
        $this->sourceDataValidator = $sourceDataValidator;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData): string
    {
        $validationResult = $this->sourceDataValidator->validate($sourceData);
        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }

        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        base64_decode($sourceData->getSourceData());

        return 'base64-filename';
    }
}

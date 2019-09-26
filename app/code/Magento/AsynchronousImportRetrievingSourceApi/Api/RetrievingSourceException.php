<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\Framework\Exception\AggregateExceptionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

/**
 * Retrieve Source Exception
 *
 * @api
 */
class RetrievingSourceException extends LocalizedException implements AggregateExceptionInterface
{
    /**
     * @var RetrievingSourceDataResultInterface|null
     */
    private $retrievingResult;

    /**
     * @param Phrase $phrase
     * @param \Exception $cause
     * @param int $code
     * @param RetrievingSourceDataResultInterface|null $retrievingResult
     */
    public function __construct(
        Phrase $phrase,
        \Exception $cause = null,
        $code = 0,
        RetrievingSourceDataResultInterface $retrievingResult = null
    ) {
        parent::__construct($phrase, $cause, $code);
        $this->retrievingResult = $retrievingResult;
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        $localizedErrors = [];
        if (null !== $this->retrievingResult) {
            foreach ($this->retrievingResult->getErrors() as $error) {
                $localizedErrors[] = new LocalizedException(__($error));
            }
        }
        return $localizedErrors;
    }
}

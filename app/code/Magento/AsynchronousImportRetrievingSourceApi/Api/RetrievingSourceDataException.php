<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataStatusInterface;
use Magento\Framework\Exception\AggregateExceptionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

/**
 * Retrieve Source Exception
 *
 * @api
 */
class RetrievingSourceDataException extends LocalizedException implements AggregateExceptionInterface
{
    /**
     * @var RetrievingSourceDataStatusInterface|null
     */
    private $retrievingStatus;

    /**
     * @param Phrase $phrase
     * @param \Exception $cause
     * @param int $code
     * @param RetrievingSourceDataStatusInterface|null $retrievingStatus
     */
    public function __construct(
        Phrase $phrase,
        \Exception $cause = null,
        $code = 0,
        RetrievingSourceDataStatusInterface $retrievingStatus = null
    ) {
        parent::__construct($phrase, $cause, $code);
        $this->retrievingStatus = $retrievingStatus;
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        $localizedErrors = [];
        if (null !== $this->retrievingStatus) {
            foreach ($this->retrievingStatus->getErrors() as $error) {
                $localizedErrors[] = new LocalizedException(__($error));
            }
        }
        return $localizedErrors;
    }
}

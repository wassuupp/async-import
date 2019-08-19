<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Model\Import\Exchange\ExchangeProcessorInterface;

/**
 *  Imports Processor Pool
 */
class ExchangeRepository
{
    /**
     * @var array
     */
    private $importProcessors;

    /**
     * Initial dependencies
     *
     * @param ExchangeProcessorInterface[] $processorsPool
     */
    public function __construct(array $processorsPool = [])
    {
        $this->processorsPool = $processorsPool;
        $this->exchange = "amqp";
    }

    /**
     * Provides processor
     * @return ExchangeProcessorInterface
     * @throws ImportServiceException
     */
    public function getExchangeProcessor(): ExchangeProcessorInterface
    {
        foreach ($this->processorsPool as $key => $processor) {
            if ($key === $this->exchange) {
                return $processor;
            }
        }
        throw new ImportServiceException(
            __('No Exchange Pool is defined')
        );
    }
}

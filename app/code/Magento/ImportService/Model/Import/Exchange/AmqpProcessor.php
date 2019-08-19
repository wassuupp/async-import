<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Exchange;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportServiceApi\Model\ImportStartResponse;
use Magento\ImportService\Model\Import\ImportProcessorTopicsPool;
use Magento\AsynchronousOperations\Model\MassSchedule;

/**
 * Class Start
 */
class AmqpProcessor implements ExchangeProcessorInterface
{

    /**
     * @var MassSchedule
     */
    private $massSchedule;

    /**
     * @var ImportProcessorTopicsPool
     */
    private $importProcessorTopicsPool;

    public function __construct(
        ImportProcessorTopicsPool $importProcessorTopicsPool,
        MassSchedule $massSchedule
    )
    {
        $this->importProcessorTopicsPool = $importProcessorTopicsPool;
        $this->massSchedule = $massSchedule;
    }


    /**
     * @param array $mappingItemsList
     * @param ImportConfigInterface $importConfig
     * @param SourceBuilderInterface $source
     * @param ImportStartResponseFactory $importResponse
     *
     * @return ImportStartResponseFactory
     */
    public function process(
        array $mappingItemsList,
        ImportConfigInterface $importConfig,
        SourceBuilderInterface $source,
        ImportStartResponse $importResponse
    ): ImportStartResponse{

        $topic = $this->importProcessorTopicsPool->getTopic($importConfig);

        $requestItems = [];
        $requestItems['prices'] = [];
        foreach ($mappingItemsList as $importLine) {
            $requestItem = [];
            foreach ($importLine as $element){
                $requestItem[$element->getTargetPath()] = $element->getSourceValue();
            }
            $requestItems['prices'][] = $requestItem;
        }

//        var_dump($requestItems);
//        exit;

        $this->massSchedule->publishMass(
            $topic,
            $requestItems,
            null,
            0
        );

        /**
         * @TODO implement import to storage. Dummy class for now
         */
        return $importResponse;

    }
}
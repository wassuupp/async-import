<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model\DataExchangingAdapter;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeAdapterInterface;
use Magento\AsynchronousOperations\Model\MassSchedule;
use Magento\Framework\Communication\Config\ReflectionGenerator;
use Magento\Framework\Exception\BulkException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\MethodsMap;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Framework\Webapi\ServiceInputProcessor;
use Zend\Http\Request;

/**
 * Data exchange adapter for processing requests based on Service contracts.
 * So module is installed as part of Magento monolyth
 *
 * @api
 */
class ServiceContracts implements ExchangeAdapterInterface
{
    const TOPIC_KEY_CODE = 'topic';

    /** @var array */
    private $exchangingProperties;

    /** @var MassSchedule */
    private $massSchedule;

    /** @var ServiceInputProcessor */
    private $serviceInputProcessor;

    /** @var ReflectionGenerator */
    private $reflectionGenerator;

    /** @var MethodsMap */
    private $methodsMap;

    /**
     * ServiceContracts constructor.
     * @param array $exchangingProperties
     * @param MassSchedule $massSchedule
     * @param ServiceInputProcessor $serviceInputProcessor
     * @param ReflectionGenerator $reflectionGenerator
     * @param MethodsMap $methodsMap
     */
    public function __construct(
        array $exchangingProperties,
        MassSchedule $massSchedule,
        ServiceInputProcessor $serviceInputProcessor,
        ReflectionGenerator $reflectionGenerator,
        MethodsMap $methodsMap
    ) {
        $this->exchangingProperties = $exchangingProperties;
        $this->massSchedule = $massSchedule;
        $this->serviceInputProcessor = $serviceInputProcessor;
        $this->reflectionGenerator = $reflectionGenerator;
        $this->methodsMap = $methodsMap;
    }

    /**
     * Execute
     *
     * @param ImportInterface $import
     * @param array $importData
     */
    public function execute(ImportInterface $import, array $importData): void
    {
        $importBehaviour = $import->getImportBehaviour();

        if (!isset($this->exchangingProperties[$import->getImportType()][$importBehaviour])) {
            // todo log and skip
        }
        $exchangingProperty = $this->exchangingProperties[$import->getImportType()][$importBehaviour];

        $topicCode = $exchangingProperty[self::TOPIC_KEY_CODE];

        $methodParams = $this->methodsMap->getMethodParams($topicCode, $importBehaviour);

        if (count($methodParams) > 1) {
            // todo log and skip;
        }

        $methodParam = array_shift($methodParams);
        $methodParamName = $methodParam['name'];

        try {
            $inputParams = $this->serviceInputProcessor->process($topicCode, $importBehaviour, [$methodParamName => $importData]);
        } catch (WebapiException $e) {
            // todo log and skip
        }

        $topicName = ['async', strtolower($topicCode), strtolower($importBehaviour)];
        try {
            $this->massSchedule->publishMass(
                $this->reflectionGenerator->generateTopicName(implode("\\", $topicName), strtolower(Request::METHOD_POST)),
                [0 => $inputParams],
                null,
                0
            );
        } catch (BulkException $e) {
            //todo log and skip
        } catch (LocalizedException $e) {
            //todo log and skip
        }
    }
}

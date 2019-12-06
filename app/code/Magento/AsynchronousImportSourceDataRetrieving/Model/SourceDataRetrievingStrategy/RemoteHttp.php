<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Api\SourceDataRetrievingException;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\Http;

/**
 * Http strategy for retrieving source data
 */
class RemoteHttp implements RetrieveSourceDataStrategyInterface
{
    public const REMOTE_HTTP_STRATEGY_NAME = "remote_http";

    /**
     * @var Http
     */
    private $httpDriver;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var string
     */
    private $dataSeparator = "\n";

    /**
     * @param Http $httpDriver
     * @param int $batchSize
     * @param string|null $dataSeparator
     */
    public function __construct(
        Http $httpDriver,
        $batchSize,
        $dataSeparator = null
    ) {
        $this->httpDriver = $httpDriver;
        $this->batchSize = $batchSize;
        if ($dataSeparator !== null) {
            $this->dataSeparator = $dataSeparator;
        }
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): \Traversable
    {
        try {
            $linkPath = str_replace("http://", "", $source->getSourceDefinition());
            $data = $this->httpDriver->fileGetContents($linkPath);
            $data = preg_replace("/[\r\n]+/", $this->dataSeparator, $data);
            $data = array_filter(explode("\n", $data));
            $resultData = [];
            $offset = 0;
            while ($sub = array_slice($data, $offset, $this->batchSize)) {
                $offset += $this->batchSize;
                $resultData[] = $sub;
            }

            return new \ArrayIterator($resultData);

        } catch (FileSystemException $e) {
            throw new SourceDataRetrievingException(
                __("Remote http resource %1 is not available", $source->getSourceDefinition())
            );
        }
    }
}

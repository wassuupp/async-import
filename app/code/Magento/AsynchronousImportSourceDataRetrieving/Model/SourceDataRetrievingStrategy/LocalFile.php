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
use Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy\LocalFile\FileResolver;
use Magento\Framework\Exception\FileSystemException;

/**
 * Local file strategy for retrieving source data
 */
class LocalFile implements RetrieveSourceDataStrategyInterface
{
    public const LOCAL_FILE_STRATEGY_NAME = "local_file";

    /**
     * @var FileResolver
     */
    private $fileResolver;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var string
     */
    private $dataSeparator = "\n";

    /**
     * @param FileResolver $fileResolver
     * @param int $batchSize
     * @param string|null $dataSeparator
     */
    public function __construct(
        FileResolver $fileResolver,
        $batchSize,
        $dataSeparator = null
    ) {
        $this->fileResolver = $fileResolver;
        $this->batchSize = $batchSize;
        if ($dataSeparator !== null) {
            $this->dataSeparator = $dataSeparator;
        }
    }

    public function execute(SourceInterface $source): \Traversable
    {
        try {
            $filePath =
                $this->fileResolver->getRootPath() . DIRECTORY_SEPARATOR . $source->getSourceDefinition();
            $data = $this->fileResolver->getFileContents($filePath);
            $data = preg_replace("/[\r\n]+/", $this->dataSeparator, $data);
            $data = array_filter(explode("\n", $data));
            $resultData = [];
            $offset = 0;
            while ($sub = array_slice($data, $offset, $this->batchSize)) {
                $offset += $this->batchSize;
                $resultData[] = $sub;
            }
        } catch (FileSystemException $e) {
            throw new SourceDataRetrievingException(
                __("Source file %1 is not available", $source->getSourceDefinition())
            );
        }
        return new \ArrayIterator($resultData);
    }
}

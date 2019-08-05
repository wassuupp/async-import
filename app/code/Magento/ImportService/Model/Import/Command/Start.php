<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Command;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportService\Model\Import\Reader\CsvFactory as CsvReader;
use Magento\ImportService\Model\Source\ReaderPool;
use Magento\ImportService\Model\Source\Resolver\CsvPath as CsvPathResolver;
use Magento\ImportService\Model\Import\Mapping\ProcessSourceItemMappingFactory as ItemMappingProcessorFactory;
use Magento\ImportService\Model\Import\Mapping\ApplyProcessingRules;
use Magento\ImportServiceApi\Model\ImportStartResponse;
use Magento\ImportService\Model\Import\Storage\Processor as ImportProcessor;
/**
 * @TODO Create more generic way for repository, source is type based, but repository itself are generic no matter which type is used and also check chain executors
 */
use Magento\ImportServiceApi\Api\SourceCsvRepositoryInterface;

/**
 * Class Start
 */
class Start implements StartInterface
{

    /**
     * @var ReaderPool
     */
    private $readerPool;

    /**
     * @var CsvReader
     */
    private $csvReader;

    /**
     * @var CsvPathResolver
     */
    private $csvPathResolver;

    /**
     * @var ItemMappingProcessor
     */
    private $itemMappingProcessor;

    /**
     * @var ApplyProcessingRules
     */
    private $applyProcessingRules;

    /**
     * @var ImportProcessor
     */
    private $importProcessor;

    /**
     * @var SourceCsvRepositoryInterface
     */
    private $sourceRepository;

    /**
     * Start constructor.
     *
     * @param CsvReader $csvReader
     */
    public function __construct(
        CsvReader $csvReader,
        ReaderPool $readerPool,
        CsvPathResolver $csvPathResolver,
        ItemMappingProcessorFactory $itemMappingProcessor,
        ApplyProcessingRules $applyProcessingRules,
        ImportProcessor $importProcessor,
        SourceCsvRepositoryInterface $sourceRepository
    ) {
        $this->csvReader = $csvReader;
        $this->readerPool = $readerPool;
        $this->itemMappingProcessor = $itemMappingProcessor;
        /**
         * @TODO we need to implement detecting of resolvers depends from source format
         */
        $this->csvPathResolver = $csvPathResolver;
        $this->applyProcessingRules = $applyProcessingRules;
        $this->importProcessor = $importProcessor;
        $this->sourceRepository = $sourceRepository;
    }

    public function execute(string $uuid, ImportConfigInterface $importConfig, ImportStartResponse $importResponse)
    {

        $source = $this->sourceRepository->getByUuid($uuid);

        $reader = $this->readerPool->getReader($source);
        $reader->rewind();

        $mappingItemsList = [];

        /** @var array $sourceItem */
        foreach ($reader as $sourceItem) {

            $processSourceItemFactory = $this->itemMappingProcessor->create([
                'data' => $sourceItem,
                'mapping' => $importConfig->getMapping(),
                'processor' => $this->csvPathResolver
            ]);
            $mappedItem = $processSourceItemFactory->process();
            $mappingItemsList[] = $this->applyProcessingRules->execute($mappedItem);


        }

        $importResponse = $this->importProcessor->process($mappingItemsList, $importConfig, $source, $importResponse);
        return $importResponse;

    }
}
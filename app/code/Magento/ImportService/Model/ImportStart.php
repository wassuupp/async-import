<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportServiceApi\Api\Data\ImportStartResponseInterface;
use Magento\ImportServiceApi\Api\ImportStartInterface;
use Magento\ImportServiceApi\Model\ImportStartResponseFactory;
/**
 * @TODO Create more generic way for repository, source is type based, but repository itself are generic no matter which type is used and also check chain executors
 */
use Magento\ImportServiceApi\Api\SourceCsvRepositoryInterface;
use Magento\ImportService\Model\Import\Command\StartInterface as ImportRunner;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{

    /**
     * @var SourceCsvRepositoryInterface
     */
    private $sourceRepository;

    /**
     * @var ImportStartResponseFactory
     */
    private $importStartResponseFactory;

    /**
     * @var ImportRunner
     */
    private $importRunner;

    /**
     * ImportStart constructor.
     *
     * @param SourceCsvRepositoryInterface $sourceRepository
     * @param ImportStartResponseFactory $importStartResponseFactory
     */
    public function __construct(
        SourceCsvRepositoryInterface $sourceRepository,
        ImportStartResponseFactory $importStartResponseFactory,
        ImportRunner $importRunner
    ) {
        $this->importStartResponseFactory = $importStartResponseFactory;
        $this->sourceRepository = $sourceRepository;
        $this->importRunner = $importRunner;
    }

    /**
     * Import start
     *
     * @param string $uuid
     * @param ImportConfigInterface $importConfig
     *
     * @return ImportStartResponseInterface
     */
    public function execute(string $uuid, ImportConfigInterface $importConfig): ImportStartResponseInterface
    {
        $importResponse = $this->importStartResponseFactory->create();
        $source = $this->sourceRepository->getByUuid($uuid);

        /**
         * @TODO add correct error handling
         */
        $importResponse = $this->importRunner->execute($source, $importConfig, $importResponse);
        return $importResponse;
    }
}

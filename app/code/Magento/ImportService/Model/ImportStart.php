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
use Magento\ImportService\Model\Import\Command\StartInterface as ImportRunner;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{

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
        ImportStartResponseFactory $importStartResponseFactory,
        ImportRunner $importRunner
    ) {
        $this->importStartResponseFactory = $importStartResponseFactory;
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

        /**
         * @TODO add correct error handling
         */
        $importResponse = $this->importRunner->execute($uuid, $importConfig, $importResponse);
        return $importResponse;
    }
}

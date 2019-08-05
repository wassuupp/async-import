<?php

namespace Magento\ImportService\Model\Import\Command;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportServiceApi\Model\ImportStartResponse;

interface StartInterface
{

    /**
     * Start Import interface
     *
     * @param string $uuid
     * @param ImportConfigInterface $importConfig
     * @param ImportStartResponse $importResponse

     * @return ImportStartResponseFactory
     */
    public function execute(string $uuid, ImportConfigInterface $importConfig, ImportStartResponse $importResponse);

}
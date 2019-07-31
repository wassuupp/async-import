<?php

namespace Magento\ImportService\Model\Import\Command;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportServiceApi\Model\ImportStartResponse;

interface StartInterface
{

    /**
     * @param SourceCsvInterface $source
     * @param ImportConfigInterface $importConfig
     *
     * @return ImportStartResponseFactory
     */
    public function execute(SourceCsvInterface $source, ImportConfigInterface $importConfig, ImportStartResponse $importResponse);

}
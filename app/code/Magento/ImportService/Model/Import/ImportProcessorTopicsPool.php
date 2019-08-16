<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportService\ImportServiceException;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;

/**
 *  Imports Processor Pool
 */
class ImportProcessorTopicsPool implements ImportProcessorTopicsPoolInterface
{
    /**
     * @var array
     */
    private $importTopics;

    /**
     * Initial dependencies
     *
     * @param array $importTopics
     */
    public function __construct(array $importTopics = [])
    {
        $this->importTopics = $importTopics;
    }

    /**
     * @param ImportConfigInterface $importConfig

     * @return string

     * @throws ImportServiceException
     */
    public function getTopic(ImportConfigInterface $importConfig): string
    {

        foreach ($this->importTopics as $key => $processorInformation) {
            if ($key == $importConfig->getImportType()){
                foreach ($processorInformation as $strategyKey => $topics){
                    if ($strategyKey == $importConfig->getImportStrategy()){
                        return $topics['topic'];
                    }
                }
            }
        }
        throw new ImportServiceException(
            __('Topic for import type is not defined')
        );
    }
}

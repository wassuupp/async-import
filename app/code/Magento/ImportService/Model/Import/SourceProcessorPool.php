<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Model\Import\Processor\SourceProcessorInterface;

/**
 *  Source Processor Pool
 */
class SourceProcessorPool
{
    /**
     * @var array
     */
    private $sourceProcessors;

    /**
     * Initial dependencies
     *
     * @param SourceProcessorInterface[] $sourceProcessors
     */
    public function __construct(array $sourceProcessors = [])
    {
        $this->sourceProcessors = $sourceProcessors;
    }

    /**
     * Provides processor
     *
     * @param SourceCsvInterface $source
     *
     * @return SourceProcessorInterface
     * @throws ImportServiceException
     */
    public function getProcessor(SourceCsvInterface $source): SourceProcessorInterface
    {
        foreach ($this->sourceProcessors as $key => $processorInformation) {
            if ($processorInformation['import_type'] === $source->getImportType()) {
                return $processorInformation['processor'];
            }
        }
        throw new ImportServiceException(
            __('Specified Import type "%1" is wrong.', $source->getImportType())
        );
    }
}

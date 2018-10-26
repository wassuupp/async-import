<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

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
    public function __construct($sourceProcessors = [])
    {
        $this->sourceProcessors = $sourceProcessors;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Magento\ImportService\Exception
     * return SourceProcessorInterface
     */
    public function getProcessor(\Magento\ImportService\Api\Data\SourceDataInterface $sourceData)
    {
        foreach ($this->sourceProcessors as $key=>$processorInformation) {
            if ($processorInformation['import_type'] === $sourceData->getSource()->getImportType()){
                return $processorInformation['processor'];
            }
        }
        throw new \Magento\ImportService\Exception(
            __('Specified Import type "%1" is wrong.', $sourceData->getSource()->getType())
        );
    }
}

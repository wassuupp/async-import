<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface SourceDataInterface
 */
interface SourceDataInterface extends ExtensibleDataInterface
{
    const SOURCE_ID = 'source_id';
    const SOURCE = 'source';

    /**
     * Retrieve import Source ID
     *
     * @return int|null
     */
    public function getSourceId();

    /**
     * @param $sourceId
     * @return mixed
     */
    public function setSourceId($sourceId);

    /**
     * Get import source
     *
     * @return \Magento\ImportService\Api\Data\SourceInterface|null
     */
    public function getSource();

    /**
     * Set import source
     *
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return $this
     */
    public function setSource($source);
}

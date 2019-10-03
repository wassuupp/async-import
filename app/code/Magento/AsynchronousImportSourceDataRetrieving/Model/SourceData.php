<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceDataInterface;

/**
 * @inheritdoc
 */
class SourceData implements SourceDataInterface
{
    /**
     * @var \Traversable
     */
    private $iterator;

    /**
     * @param \Traversable $iterator
     */
    public function __construct(\Traversable $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): \Traversable
    {
        return $this->iterator;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;

/**
 * @inheritdoc
 */
class RetrievingSourceDataResult implements RetrievingSourceDataResultInterface
{
    /**
     * @var string|null
     */
    private $file;

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * @inheritdoc
     */
    public function getFile(): ?string
    {
        return $this->file;
    }
}

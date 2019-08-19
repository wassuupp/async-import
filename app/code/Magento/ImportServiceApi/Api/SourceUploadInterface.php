<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api;

use Magento\ImportServiceApi\Api\Data\SourceBuilderInterface;

/**
 * Class SourceBuilderInterface
 */
interface SourceUploadInterface
{
    /**
     * Upload source.
     *
     * @param \Magento\ImportServiceApi\Api\Data\SourceBuilderInterface $source
     * @return \Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface
     */
    public function execute(SourceBuilderInterface $source);
}

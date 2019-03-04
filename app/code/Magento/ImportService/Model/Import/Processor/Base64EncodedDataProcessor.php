<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;

/**
 * Base64 encoded data processor for asynchronous import
 */
class Base64EncodedDataProcessor extends AbstractSourceProcessor
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'base64_encoded_data';

    /**
     *  {@inheritdoc}
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        /** @var string $content */
        $content = base64_decode($source->getImportData());

        /** Set decoded imported data */
        $source->setImportData($content);

        /** process source and get response details */
        return parent::processUpload($source, $response);
    }
}

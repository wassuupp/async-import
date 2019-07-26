<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\Model\Source\Validator\ValidatorInterface;

/**
 * Base64 encoded data processor for asynchronous import
 */
class Base64EncodedDataProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    public const IMPORT_TYPE = 'base64_encoded_data';

    /**
     * @var PersistentSourceProcessor
     */
    private $persistentUploader;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param PersistentSourceProcessor $persistentUploader
     * @param ValidatorInterface $validator
     */
    public function __construct(
        PersistentSourceProcessor $persistentUploader,
        ValidatorInterface $validator
    ) {
        $this->persistentUploader = $persistentUploader;
        $this->validator = $validator;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(
        SourceCsvInterface $source,
        SourceUploadResponseInterface $response
    ): SourceUploadResponseInterface {
        $this->validator->validate($source);
        /** @var string $content */
        $content = base64_decode($source->getImportData());
        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return $this->persistentUploader->processUpload($source, $response);
    }
}

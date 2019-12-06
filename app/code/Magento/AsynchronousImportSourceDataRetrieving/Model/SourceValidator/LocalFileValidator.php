<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportSourceDataRetrieving\Model\SourceValidator;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportSourceDataRetrievingApi\Model\SourceValidatorInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy\LocalFile;
use Magento\AsynchronousImportSourceDataRetrieving\Model\SourceDataRetrievingStrategy\LocalFile\FileResolver;

/**
 * @inheritdoc
 */
class LocalFileValidator implements SourceValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    private $fileResolver;

    /**
     * LocalFileValidator constructor.
     * @param ValidationResultFactory $validationResultFactory
     * @param FileResolver $fileResolver
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        FileResolver $fileResolver
    ) {
        $this->validationResultFactory = $validationResultFactory;
        $this->fileResolver = $fileResolver;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceInterface $source): ValidationResult
    {
        $errors = [];
        if ($source->getSourceType() !== LocalFile::LOCAL_FILE_STRATEGY_NAME) {
            return $this->validationResultFactory->create(['errors' => $errors]);
        }
        $fileName = (string)$source->getSourceDefinition();
        $sourceDataFormat = (string)$source->getSourceDataFormat();
        $errors = $this->validateLocalFile($fileName, $sourceDataFormat);
        return $this->validationResultFactory->create(['errors' => $errors]);
    }

    /**
     * Validate local file availability and file MIME type
     *
     * @param string $fileName
     * @param string $sourceDataFormat
     * @return array
     */
    private function validateLocalFile(string $fileName, string $sourceDataFormat): array
    {
        $errors = [];
        $fileNotAvailError = __(
            'Invalid "%field". Remote file is not available.',
            ['field' => SourceInterface::SOURCE_DEFINITION]
        );
        try {
            $filePath = $this->fileResolver->getRootPath() . DIRECTORY_SEPARATOR . $fileName;
            $fileAvailable = $this->fileResolver->isFileAvailable($filePath);
            if (!$fileAvailable) {
                $errors[] = $fileNotAvailError;
            } else {
                // phpcs:ignore Magento2.Functions.DiscouragedFunction
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (! $fileExtension
                    || ! preg_match("/\\.{$fileExtension}$/", $sourceDataFormat)
                ) {
                    $errors[] = __(
                        'Invalid "%field". Local file has incorrect mime type.',
                        ['field' => SourceInterface::SOURCE_DATA_FORMAT]
                    );
                }
            }
        } catch (FileSystemException $e) {
            $errors[] = $fileNotAvailError;
        }
        return $errors;
    }
}

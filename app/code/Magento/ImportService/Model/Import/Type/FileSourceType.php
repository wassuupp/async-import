<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Type;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DataObject\IdentityGeneratorInterface as IdentityGenerator;
use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceApi\Api\SourceRepositoryInterface;
use Magento\ImportService\ImportServiceException;

/**
 * Generic Source Type
 */
class FileSourceType implements SourceTypeInterface
{
    /**
     * @var SourceRepositoryInterface
     */
    private $sourceRepository;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var IdentityGeneratorInterface
     */
    private $identityGenerator;

    /**
     * @var string
     */
    private $sourceType;

    /**
     * @var array
     */
    private $allowedMimeTypes;

    /**
     * File Type constructor.
     *
     * @param SourceRepositoryInterface $sourceRepository
     * @param Filesystem $filesystem
     * @param IdentityGenerator $identityGenerator
     * @param string $sourceType
     * @param array $allowedMimeTypes
     */
    public function __construct(
        SourceRepositoryInterface $sourceRepository,
        Filesystem $filesystem,
        IdentityGenerator $identityGenerator,
        string $sourceType = null,
        array $allowedMimeTypes = []
    ) {
        $this->sourceRepository = $sourceRepository;
        $this->filesystem = $filesystem;
        $this->identityGenerator = $identityGenerator;
        $this->sourceType = $sourceType;
        $this->allowedMimeTypes = $allowedMimeTypes;
    }

    /**
     * Get file source type
     *
     * @return string
     */
    private function getFileExtension(): string
    {
        return '.' . $this->sourceType;
    }

    /**
     * get all mime types
     *
     * @return array
     */
    public function getAllowedMimeTypes(): array
    {
        return $this->allowedMimeTypes;
    }

    /**
     * Save source content
     *
     * @param SourceBuilderInterface $source
     *
     * @return SourceBuilderInterface
     * @throws FileSystemException
     * @throws ImportServiceException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(SourceBuilderInterface $source): SourceBuilderInterface
    {
        $uuid = $source->getUuid() ?: $this->identityGenerator->generateId();
        $fileName = $uuid . $this->getFileExtension();
        $contentFilePath =  SourceTypeInterface::IMPORT_SOURCE_FILE_PATH . $fileName;
        $varDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        if (!$varDirectory->writeFile($contentFilePath, $source->getImportData())) {
            $lastError = error_get_last();
            $errorMessage = $lastError['message'] ?? '';
            throw new ImportServiceException(
                __('Cannot create file with given source: %1', $errorMessage)
            );
        }
        $source->setImportData($fileName)->setUuid($uuid)->setStatus(SourceBuilderInterface::STATUS_UPLOADED);
        $source = $this->sourceRepository->save($source);
        $source = $this->sourceRepository->getByUuid($source->getUuid());

        return $source;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbsolutePathToFile(SourceBuilderInterface $source)
    {
        /** @var string $contentFilePath */
        $contentFilePath = SourceTypeInterface::IMPORT_SOURCE_FILE_PATH . $source->getImportData();
        /** @var \Magento\Framework\Filesystem\Directory\Write $var */
        $dirReader = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);
        return $dirReader->getAbsolutePath($contentFilePath);
    }
}

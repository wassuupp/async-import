<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\SourceRepositoryInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceSourceCsvApi\Api\SourceCsvGetInterface;
use Magento\ImportService\Model\SourceCsvFormatFactory as FormatFactory;

/**
 * Class SourceCsvUpdate
 */
class SourceCsvGet implements SourceCsvGetInterface
{
    /**
     * @var SourceRepositoryInterface
     */
    private $sourceRepository;

    /**
     * @var SourceBuilderInterface
     */
    private $sourceBuilder;

    /**
     * Source format factory
     *
     * @var FormatFactory
     */
    private $formatFactory;

    /**
     * @var SourceCsvInterface
     */
    private $sourceCsv;

    /**
     * SourceCsvUpdate constructor.
     *
     * @param SourceRepositoryInterface $sourceRepository
     * @param SourceBuilderInterface $sourceBuilder
     * @param SourceCsvInterface $sourceBuilder
     */
    public function __construct(
        SourceRepositoryInterface $sourceRepository,
        SourceBuilderInterface $sourceBuilder,
        SourceCsvInterface $sourceCsv,
        FormatFactory $formatFactory
    ) {
        $this->sourceRepository = $sourceRepository;
        $this->sourceBuilder = $sourceBuilder;
        $this->sourceCsv = $sourceCsv;
        $this->formatFactory = $formatFactory;
    }

    /**
     * Update source.
     *
     * @param string $uuid
     * @param SourceCsvInterface $source
     *
     * @return SourceUploadResponse
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function execute(string $uuid): SourceCsvInterface
    {
        $source = $this->sourceRepository->getByUuid($uuid);
        if ($source->getId()) {
            if ($source->getSourceType() !== SourceCsvInterface::CSV_SOURCE_TYPE) {
                throw new ImportServiceException(
                    __('Specified Source type "%1" is wrong.', SourceCsvInterface::CSV_SOURCE_TYPE)
                );
            }

            $sourceFormat = $source->getFormat();
            $source->unsetData("format");
            $format = $this->formatFactory->create()->setData($sourceFormat);

            $this->sourceCsv->setData($source->getData());
            $this->sourceCsv->setFormat($format);

        } else {
            throw new ImportServiceException(
                __('Specified uuid "%1" does not exist.', $uuid)
            );
        }

        return $this->sourceCsv;
    }
}

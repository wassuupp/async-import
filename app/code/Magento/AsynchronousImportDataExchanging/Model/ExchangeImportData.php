<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataExchanging\Model;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ExchangeImportDataInterface;
use Magento\AsynchronousImportDataExchangingApi\Api\ImportDataExchangeException;
use Magento\AsynchronousImportDataExchangingApi\Model\ExchangeDataStrategyInterface;
use Magento\AsynchronousImportDataExchangingApi\Model\ImportValidatorInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class ExchangeImportData implements ExchangeImportDataInterface
{
    /**
     * @var ImportValidatorInterface
     */
    private $importValidator;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var ExchangeDataStrategyInterface[]
     */
    private $exchangingStrategies;

    /**
     * @param ImportValidatorInterface $importValidator
     * @param ValidationResultFactory $validationResultFactory
     * @param ExchangeDataStrategyInterface[] $exchangingStrategies
     * @throws ImportDataExchangeException
     */
    public function __construct(
        ImportValidatorInterface $importValidator,
        ValidationResultFactory $validationResultFactory,
        array $exchangingStrategies
    ) {
        $this->importValidator = $importValidator;
        $this->validationResultFactory = $validationResultFactory;
        $this->exchangingStrategies = $exchangingStrategies;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportInterface $import, array $importData): void
    {
        $validationResult = $this->importValidator->validate($import);
        if (false === $validationResult->isValid()) {
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }

        $importType = $import->getImportType();
        $importBehaviour = $import->getImportBehaviour();
        if (!isset($this->exchangingStrategies[$importType]) || !isset($this->exchangingStrategies[$importType][$importBehaviour])) {
            $validationResult = $this->validationResultFactory->create(
                [
                    'errors' => [
                        __('Import type "%import_type" with behaviour "%import_behaviour" is not supported.', ['import_type' => $importType, 'import_behaviour' => $importBehaviour])
                    ]
                ]
            );
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }
        $this->exchangingStrategies[$importType][$importBehaviour]->execute($import, $importData);
    }
}

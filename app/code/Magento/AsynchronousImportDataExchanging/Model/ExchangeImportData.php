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
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class ExchangeImportData implements ExchangeImportDataInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ImportValidatorInterface
     */
    private $importValidator;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var array
     */
    private $exchangingStrategies;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ImportValidatorInterface $importValidator
     * @param ValidationResultFactory $validationResultFactory
     * @param array $exchangingStrategies
     * @throws ImportDataExchangeException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ImportValidatorInterface $importValidator,
        ValidationResultFactory $validationResultFactory,
        array $exchangingStrategies
    ) {
        $this->objectManager = $objectManager;
        $this->importValidator = $importValidator;
        $this->validationResultFactory = $validationResultFactory;

        foreach ($exchangingStrategies as $exchangingStrategy) {
            if (!$exchangingStrategy instanceof ExchangeDataStrategyInterface) {
                throw new ImportDataExchangeException(
                    __('Validator must implement ' . ExchangeDataStrategyInterface::class . '.')
                );
            }
        }
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
        if (!isset($this->exchangingStrategies[$importType])) {
            $validationResult = $this->validationResultFactory->create(
                [
                    'errors' => [
                        __('Import type "%import_type" is not supported.', ['import_type' => $importType]),
                    ],
                ]
            );
            throw new ValidationException(__('Validation Failed.'), null, 0, $validationResult);
        }

        /** @var ExchangeDataStrategyInterface $exchangingStrategy */
        $exchangingStrategy = $this->objectManager->get($this->exchangingStrategies[$importType]);
        $exchangingStrategy->execute($import, $importData);
    }
}

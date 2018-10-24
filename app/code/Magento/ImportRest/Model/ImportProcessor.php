<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportRest\Model;

/**
 * Class ImportProcessor
 *
 * @package Magento\ImportRest\Model
 */
class ImportProcessor implements \Magento\ImportRest\Api\ImportProcessorInterface
{
    /**
     * @var \Magento\ImportExport\Model\ImportFactory
     */
    private $importModelFactory;

    /**
     * @param \Magento\ImportExport\Model\ImportFactory $importModelFactory
     */
    public function __construct(
        \Magento\ImportExport\Model\ImportFactory $importModelFactory
    ) {
        $this->importModelFactory = $importModelFactory;
    }

    /**
     * @inheritdoc
     */
    public function executeImport($importEntry)
    {
        try {
            $data = [
                'entity' => 'catalog_product',
                'behavior' => 'append',
                'validation_strategy' => 'validation-skip-errors',
                'allowed_error_count' => '10000',
                '_import_field_separator' => ',',
                '_import_multiple_value_separator' => ',',
                '_import_empty_attribute_value_constant' => '__EMPTY__VALUE__',
                'import_images_file_dir' => '',
            ];
            /** @var \Magento\ImportExport\Model\Import $importModel */
            $importModel = $this->importModelFactory->create($data);
            $importModel->importSource();
            //$importModel->processImport();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\Framework\Filesystem\Driver\Http as HttpDriver;
use Magento\Framework\Filesystem\Driver\Http\Proxy as Http;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 * Class RemoteUrlValidator
 */
class RemoteUrlValidator implements ValidatorInterface
{
    /**
     * @var HttpDriver
     */
    private $httpDriver;

    /**
     * @param Http $httpDriver
     */
    public function __construct(
        Http $httpDriver
    ) {
        $this->httpDriver = $httpDriver;
    }

    /**
     * Return error messages in array
     *
     * @param SourceBuilderInterface $source
     *
     * @return array
     */
    public function validate(SourceBuilderInterface $source)
    {
        $errors = [];

        /** check empty variable */
        $importData = $source->getImportData();

        if (isset($importData) && $importData !== '') {
            $externalSourceUrl = preg_replace('(^https?://)', '', $importData);

            /** check for file exists */
            if (!$this->httpDriver->isExists($externalSourceUrl)) {
                $errors[] = __('Remote file %1 does not exist.', $importData);
            }
        }

        return $errors;
    }
}

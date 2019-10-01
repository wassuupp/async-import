<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Start import test
 */
class StartImportTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/csv';
    const SERVICE_NAME = 'asynchronousImportCsvApiStartImportV1';
    /**#@-*/

    public function testStartImport()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'operation' => self::SERVICE_NAME . 'Execute',
            ],
        ];

        $csvString = "value1\nvalue2\nvalue3\nvalue4\nvalue5";
        $data = [
            'source' => [
                'sourceType' => 'base64_encoded_data',
                'sourceDefinition' => base64_encode($csvString),
                'sourceDataFormat' => 'CSV',
            ],
            'import' => [
                'importType' => 'advanced_pricing',
                'importBehaviour' => 'add',
            ],
        ];
        $this->_webApiCall($serviceInfo, $data);
    }

    public function testStartWithNotRequiredParameters()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'operation' => self::SERVICE_NAME . 'Execute',
            ],
        ];

        $csvString = "value1\nvalue2\nvalue3\nvalue4\nvalue5";
        $data = [
            'source' => [
                'sourceType' => 'base64_encoded_data',
                'sourceDefinition' => base64_encode($csvString),
                'sourceDataFormat' => 'CSV',
            ],
            'import' => [
                'uuid' => 'test',
                'importType' => 'advanced_pricing',
                'importBehaviour' => 'add',
                'extensionAttributes' => [],
            ],
            'format' => [
                'escape' => '|',
                'enclosure' => '|',
                'delimiter' => '|',
                'multipleValueSeparator' => '|',
                'extensionAttributes' => [],
            ],
        ];
        $this->_webApiCall($serviceInfo, $data);
    }
}

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
 * Source Data Upload test
 */
class SourceDataUploadTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/source';
    /**#@-*/

    public function testStartImport()
    {
        if (TESTS_WEB_API_ADAPTER === self::ADAPTER_SOAP) {
            $this->markTestSkipped('Do not support SOAP for new functionallity.');
        }
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST,
            ],
        ];

        $csvString = "value1\nvalue2\nvalue3\nvalue4\nvalue5";
        $data = [
            'sourceData' => [
                'sourceType' => 'base64_encoded_data',
                'sourceDefinition' => base64_encode($csvString),
                'sourceDataFormat' => 'CSV',
            ]
        ];
        $this->_webApiCall($serviceInfo, $data);
    }
}

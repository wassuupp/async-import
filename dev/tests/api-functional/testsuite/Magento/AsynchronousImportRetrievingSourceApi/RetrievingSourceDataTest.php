<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Retrieve source data test
 */
class RetrievingSourceDataTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/source-data';
    const SERVICE_NAME = 'asynchronousImportRetrievingSourceApiRetrieveSourceDataV1';
    /**#@-*/

    public function testRetrievingSourceData()
    {
        $this->markTestIncomplete();
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

        $data = [
            'sourceData' => [
                'sourceType' => 'base64_encoded_data',
                'sourceData' => 'value2',
                'sourceDataFormat' => 'csv',
            ],
        ];
        $this->_webApiCall($serviceInfo, $data);
    }
}

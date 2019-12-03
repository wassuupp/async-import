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

        $csvString = <<<csv
"sku","tier_price_website","tier_price_customer_group","tier_price_qty","tier_price","tier_price_value_type"
"Test","All Websites [USD]","ALL GROUPS","2","10","Fixed"
"Test","All Websites [USD]","ALL GROUPS","3","15","Discount"
"Test","All Websites [USD]","ALL GROUPS","4","20","Discount"
"Test","All Websites [USD]","ALL GROUPS","5","25","Discount"
"Test","All Websites [USD]","ALL GROUPS","6","30","Discount"
csv;

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

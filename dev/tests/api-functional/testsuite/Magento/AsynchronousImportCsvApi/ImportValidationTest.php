<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\ImportInterface;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Start import with invalid import request test
 */
class ImportValidationTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/csv';
    /**#@-*/

    /**
     * @param array $import
     * @param array $expectedErrorData
     * @dataProvider dataProviderInvalidData
     * @throws \Exception
     */
    public function testStartImportWithInvalidImport(array $import, array $expectedErrorData)
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

        $data = [
            'source' => [
                'sourceType' => 'base64_encoded_data',
                'sourceDefinition' => base64_encode("value1\nvalue2\nvalue3\nvalue4\nvalue5"),
                'sourceDataFormat' => 'CSV',
            ],
            'import' => $import,
        ];
        $this->assertWebApiCallErrors($serviceInfo, $data, $expectedErrorData);
    }

    /**
     * @return array
     */
    public function dataProviderInvalidData(): array
    {
        return [
            'empty_import_type' => [
                [
                    'importType' => '',
                    'importBehaviour' => 'add',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => ImportInterface::IMPORT_TYPE,
                            ],
                        ],
                    ],
                ],
            ],
            'unsupported_import_type' => [
                [
                    'importType' => 'unsupported_import_type',
                    'importBehaviour' => 'add',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Import type "%import_type" is not supported.',
                            'parameters' => [
                                'import_type' => 'unsupported_import_type',
                            ],
                        ],
                    ],
                ],
            ],
            'empty_import_behaviour' => [
                [
                    'importType' => 'advanced_price',
                    'importBehaviour' => '',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => ImportInterface::IMPORT_BEHAVIOUR,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

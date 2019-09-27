<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi;

use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Retrieve source data test
 */
class RetrievingSourceDataWithBase64StrategyTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/source-data';
    const SERVICE_NAME = 'asynchronousImportRetrievingSourceApiRetrieveSourceDataV1';
    /**#@-*/

    public function testRetrievingSourceData()
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

        $data = [
            'sourceData' => [
                'sourceType' => 'base64_encoded_data',
                'sourceData' => base64_encode('value2'),
                'sourceDataFormat' => 'CSV',
            ],
        ];
        $result = $this->_webApiCall($serviceInfo, $data);

        self::assertArrayHasKey('file', $result);
        self::assertNotEmpty($result['file']);
    }

    /**
     * @param array $sourceData
     * @param array $expectedErrorData
     * @dataProvider dataProviderInvalidSourceData
     * @throws \Exception
     */
    public function testRetrievingSourceDataWithInvalidParameters(array $sourceData, array $expectedErrorData)
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

        $data = [
            'sourceData' => $sourceData,
        ];
        $this->assertWebApiCallErrors($serviceInfo, $data, $expectedErrorData);
    }

    /**
     * @return array
     */
    public function dataProviderInvalidSourceData(): array
    {
        return [
            'unsupported_source_type' => [
                [
                    'sourceType' => 'unsupported_source_type',
                    'sourceData' => base64_encode('value2'),
                    'sourceDataFormat' => 'CSV',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Source type "%source_type" is not supported.',
                            'parameters' => [
                                'source_type' => 'unsupported_source_type',
                            ],
                        ],
                    ],
                ],
            ],
            'invalid_base64_data' => [
                [
                    'sourceType' => 'base64_encoded_data',
                    'sourceData' => '#invalid_base64_data',
                    'sourceDataFormat' => 'CSV',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Base64 import data string is invalid.',
                            'parameters' => [],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array $serviceInfo
     * @param array $data
     * @param array $expectedErrorData
     * @return void
     * @throws \Exception
     */
    private function assertWebApiCallErrors(array $serviceInfo, array $data, array $expectedErrorData)
    {
        try {
            $this->_webApiCall($serviceInfo, $data);
            $this->fail('Expected throwing exception');
        } catch (\Exception $e) {
            if (TESTS_WEB_API_ADAPTER === self::ADAPTER_REST) {
                self::assertEquals($expectedErrorData, $this->processRestExceptionResult($e));
                self::assertEquals(Exception::HTTP_BAD_REQUEST, $e->getCode());
            } elseif (TESTS_WEB_API_ADAPTER === self::ADAPTER_SOAP) {
                $this->assertInstanceOf('SoapFault', $e);
                $expectedWrappedErrors = [];
                foreach ($expectedErrorData['errors'] as $error) {
                    // @see \Magento\TestFramework\TestCase\WebapiAbstract::getActualWrappedErrors()
                    $expectedWrappedErrors[] = [
                        'message' => $error['message'],
                        'params' => $error['parameters'],
                    ];
                }
                $this->checkSoapFault($e, $expectedErrorData['message'], 'env:Sender', [], $expectedWrappedErrors);
            } else {
                throw $e;
            }
        }
    }
}

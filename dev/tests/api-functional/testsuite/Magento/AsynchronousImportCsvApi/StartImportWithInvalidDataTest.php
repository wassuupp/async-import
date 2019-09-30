<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi;

use Magento\AsynchronousImportSourceDataRetrievingApi\Api\Data\SourceInterface;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Start import with invalid data test
 */
class StartImportWithInvalidDataTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/csv';
    const SERVICE_NAME = 'asynchronousImportCsvApiStartImportV1';
    /**#@-*/

    /**
     * @param array $source
     * @param array $expectedErrorData
     * @dataProvider dataProviderInvalidSource
     * @throws \Exception
     */
    public function testStartImportWithInvalidSource(array $source, array $expectedErrorData)
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
            'source' => $source,
            'import' => [
                'importType' => 'advanced_pricing',
                'importBehaviour' => 'add',
            ],
        ];
        $this->assertWebApiCallErrors($serviceInfo, $data, $expectedErrorData);
    }

    /**
     * @return array
     */
    public function dataProviderInvalidSource(): array
    {
        return [
            'empty_source_type' => [
                [
                    'sourceType' => '',
                    'sourceDefinition' => base64_encode('value2'),
                    'sourceDataFormat' => 'CSV',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => SourceInterface::SOURCE_TYPE,
                            ],
                        ],
                    ],
                ],
            ],
            'unsupported_source_type' => [
                [
                    'sourceType' => 'unsupported_source_type',
                    'sourceDefinition' => base64_encode('value2'),
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
            'empty_source_definition' => [
                [
                    'sourceType' => 'base64_encoded_data',
                    'sourceDefinition' => '',
                    'sourceDataFormat' => 'CSV',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => SourceInterface::SOURCE_DEFINITION,
                            ],
                        ],
                    ],
                ],
            ],
            'invalid_base64_data' => [
                [
                    'sourceType' => 'base64_encoded_data',
                    'sourceDefinition' => '#invalid_base64_data',
                    'sourceDataFormat' => 'CSV',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Base64 import data string is invalid.',
                        ],
                    ],
                ],
            ],
            'empty_source_data_format' => [
                [
                    'sourceType' => 'base64_encoded_data',
                    'sourceDefinition' => base64_encode('value2'),
                    'sourceDataFormat' => '',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => SourceInterface::SOURCE_DATA_FORMAT,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }


}

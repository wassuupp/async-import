<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi;

use Magento\AsynchronousImportConvertingRulesApi\Api\Data\ConvertingRuleInterface;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Start import with invalid converting rule test
 */
class ConvertingRuleValidationTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/csv';
    const SERVICE_NAME = 'asynchronousImportCsvApiStartImportV1';
    /**#@-*/

    /**
     * @param array $convertingRule
     * @param array $expectedErrorData
     * @dataProvider dataProviderInvalidData
     * @throws \Exception
     */
    public function testStartImportWithInvalidSource(array $convertingRule, array $expectedErrorData)
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
            'source' => [
                'sourceType' => 'base64_encoded_data',
                'sourceDefinition' => base64_encode("value1\nvalue2\nvalue3\nvalue4\nvalue5"),
                'sourceDataFormat' => 'CSV',
            ],
            'import' => [
                'importType' => 'advanced_pricing',
                'importBehaviour' => 'add',
            ],
            'convertingRules' => [
                $convertingRule
            ]
        ];
        $this->assertWebApiCallErrors($serviceInfo, $data, $expectedErrorData);
    }

    /**
     * @return array
     */
    public function dataProviderInvalidData(): array
    {
        return [
            'empty_converting_rule_identifier' => [
                [
                    'identifier' => '',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => ConvertingRuleInterface::IDENTIFIER,
                            ],
                        ],
                    ],
                ],
            ],
            'unsupported_converting_rule' => [
                [
                    'identifier' => 'unsupported_source_type',
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Converting rule "%identifier" is not supported.',
                            'parameters' => [
                                'identifier' => 'unsupported_source_type',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi;

use Magento\AsynchronousImportDataConverting\Model\RuleApplyingStrategy\StringReplace;
use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * StringReplace converting rule test
 */
class StringReplaceRuleTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/csv';
    const SERVICE_NAME = 'asynchronousImportCsvApiStartImportV1';
    /**#@-*/

    public function testStartImportWithConvertingRule()
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

        $csvString = "header1,header2\nvalue1-1,value1-2\nvalue2-1,value2-2\nvalue3-1,value3-2\nvalue4-1,value4-2";
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
            'convertingRules' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => ['header1'],
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
            ],
        ];
        $this->_webApiCall($serviceInfo, $data);
    }

    /**
     * @param array $convertingRule
     * @param array $expectedErrorData
     * @dataProvider dataProviderInvalidData
     * @throws \Exception
     */
    public function testStartImportWithInvalidConvertingRule(array $convertingRule, array $expectedErrorData)
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
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function dataProviderInvalidData(): array
    {
        return [
            'missed_converting_rule_apply_to' => [
                [
                    'identifier' => 'string_replace',
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => ConvertingRuleInterface::APPLY_TO,
                            ],
                        ],
                    ],
                ],
            ],
            'empty_converting_rule_apply_to' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => [],
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => '"%field" cannot be empty.',
                            'parameters' => [
                                'field' => ConvertingRuleInterface::APPLY_TO,
                            ],
                        ],
                    ],
                ],
            ],
            'wrong_format_converting_rule_apply_to' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => 'string_but_not_array',
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
                TESTS_WEB_API_ADAPTER === self::ADAPTER_REST
                    ?
                    [
                        'message' => 'The "string" value\'s type is invalid. The "string[]" type was expected. Verify'
                            . ' and try again.',
                    ]
                    :
                    [
                        'message' => 'Validation Failed.',
                        'errors' => [
                            [
                                'message' => '"%field" cannot be empty.',
                                'parameters' => [
                                    'field' => ConvertingRuleInterface::APPLY_TO,
                                ],
                            ],
                        ],
                    ]
            ],
            'missed_search_parameter' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => ['header1'],
                    'parameters' => [
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Parameter "%field" cannot be empty.',
                            'parameters' => [
                                'field' => StringReplace::PARAMETER_SEARCH,
                            ],
                        ],
                    ],
                ],
            ],
            'empty_search_parameter' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => ['header1'],
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => '',
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Parameter "%field" cannot be empty.',
                            'parameters' => [
                                'field' => StringReplace::PARAMETER_SEARCH,
                            ],
                        ],
                    ],
                ],
            ],
            'missed_replace_parameter' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => ['header1'],
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                    ],
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Parameter "%field" cannot be empty.',
                            'parameters' => [
                                'field' => StringReplace::PARAMETER_REPLACE,
                            ],
                        ],
                    ],
                ],
            ],
            'empty_replace_parameter' => [
                [
                    'identifier' => 'string_replace',
                    'applyTo' => ['header1'],
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                        StringReplace::PARAMETER_REPLACE => '',
                    ],
                ],
                [
                    'message' => 'Validation Failed.',
                    'errors' => [
                        [
                            'message' => 'Parameter "%field" cannot be empty.',
                            'parameters' => [
                                'field' => StringReplace::PARAMETER_REPLACE,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

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
 * YesNoToBool converting rule test
 */
class YesNoToBoolRuleTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/csv';
    /**#@-*/

    public function testStartImportWithConvertingRule()
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

        $csvString = "header1,header2\nvalue1-1,value1-2\nno,no\nyes,yes";
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
                    'identifier' => 'yes_no_to_bool',
                    'applyTo' => ['header1'],
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
                    'identifier' => 'yes_no_to_bool',
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
                    'identifier' => 'yes_no_to_bool',
                    'applyTo' => [],
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
                    'identifier' => 'yes_no_to_bool',
                    'applyTo' => 'string_but_not_array',
                    'parameters' => [
                        StringReplace::PARAMETER_SEARCH => 'value',
                        StringReplace::PARAMETER_REPLACE => 'replace',
                    ],
                ],
                [
                    'message' => 'The "string" value\'s type is invalid. The "string[]" type was expected. Verify'
                        . ' and try again.',
                ],
            ],
        ];
    }
}

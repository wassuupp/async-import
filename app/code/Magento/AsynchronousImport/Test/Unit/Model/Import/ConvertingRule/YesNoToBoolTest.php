<?php
/**
 * This file is part of the Mothership GmbH code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Test\Unit\Model\Import\ConvertingRule;

use Magento\AsynchronousImport\Model\Import\ConvertingRule\YesNoToBool;
use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\Framework\Exception\NotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class YesNoToBoolTest
 *
 */
class YesNoToBoolTest extends TestCase
{
    /** @var YesNoToBool */
    private $instance;

    /** @var MockObject|ImportDataInterface */
    private $importDataMock;
    /** @var MockObject|ConvertingRuleInterface */
    private $convertingRuleMock;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->instance = new YesNoToBool();

        $this->importDataMock = $this->createMock(ImportDataInterface::class);
        $this->convertingRuleMock = $this->createMock(ConvertingRuleInterface::class);
    }

    /**
     * Covers the case, when there is no apply_to-parameter or its value is empty.
     * Then we bail out early and return the importData unconverted and immediately.
     *
     * @throws NotFoundException
     */
    public function testExecute_ApplyToIsNotSetInParameters_ReturnImportData()
    {
        // prepare
        $this->convertingRuleMock->method('getParameters')->willReturn([]);

        // invoke
        $actual = $this->instance->execute($this->importDataMock, $this->convertingRuleMock);

        // assert
        $this->assertEquals($this->importDataMock, $actual);
    }

    /**
     * Covers the case when there is an apply_to-parameter having values but at least for one value there is no column.
     * Then an exception is thrown.
     *
     * @throws NotFoundException
     */
    public function testExecute_ApplyToIsSetInParametersButAtLeastOneColumnInApplyToDoesNotExist_TrowAnException()
    {
        // prepare
        $this->convertingRuleMock->method('getParameters')->willReturn(['apply_to' => ['some_not_existing_column', 'some_other_not_existing_column']]);

        $headers = ['column_1', 'column_2', 'column_3'];
        $rows = [
            ['value_11', 'value_12', 'value_13'],
            ['value_21', 'value_22', 'value_23'],
            ['value_31', 'value_32', 'value_33'],
        ];
        $this->importDataGetData([$headers], $rows);

        // assert
        $this->expectException(NotFoundException::class);

        // invoke
        $this->instance->execute($this->importDataMock, $this->convertingRuleMock);
    }

    /**
     * Covers the case when there is an apply_to-parameter having values and for all values exist a column.
     * Then we convert the affected values
     *
     * @throws NotFoundException
     */
    public function testExecute_ApplyToIsSetInParametersAllColumnsInApplyToExist_DoSomething()
    {
        // prepare
        $applyToColumn = 'apply_to_column';
        $this->convertingRuleMock->method('getParameters')->willReturn(['apply_to' => [$applyToColumn]]);

        $headers = ['column_1', $applyToColumn, 'column_2'];
        $rows = [
            ['value_11', 'value_12', 'value_13'],
            ['value_21', 'value_22', 'value_23'],
            ['value_31', 'value_32', 'value_33'],
        ];
        $this->importDataGetData([$headers], $rows);

        // assert
        $this->importDataMock->expects($this->once())->method('setData')->with(array_merge([$headers], $rows));

        // invoke
        $this->instance->execute($this->importDataMock, $this->convertingRuleMock);
    }

    /**
     * Kurzbeschreibung
     *
     * @throws NotFoundException
     */
    public function testExecute_ImportValuesCanBeConveerted_ReturnTheConvertedData()
    {
        // prepare
        $applyToColumn = 'apply_to_column';
        $this->convertingRuleMock->method('getParameters')->willReturn(['apply_to' => [$applyToColumn]]);

        $headers = ['column_1', $applyToColumn, 'column_2'];
        $rows = [
            ['some_value', 'YES', 'some_value'],
            ['some_value', 'yes', 'some_value'],
            ['some_value', 'Yes', 'some_value'],
            ['some_value', 'NO', 'some_value'],
            ['some_value', 'No', 'some_value'],
            ['some_value', 'no', 'some_value'],
            ['some_value', 'YesNo', 'some_value'],
        ];
        $this->importDataGetData([$headers], $rows);

        // assert
        $convertedData = [
            $headers,
            ['some_value', 1, 'some_value'],
            ['some_value', 1, 'some_value'],
            ['some_value', 1, 'some_value'],
            ['some_value', 0, 'some_value'],
            ['some_value', 0, 'some_value'],
            ['some_value', 0, 'some_value'],
            ['some_value', 'YesNo', 'some_value'],
        ];
        $this->importDataMock->expects($this->once())->method('setData')->with($convertedData);

        // invoke
        $this->instance->execute($this->importDataMock, $this->convertingRuleMock);
    }

    /**
     * Kurzbeschreibung
     *
     * @param array $headers
     * @param array $rows
     */
    private function importDataGetData(array $headers, array $rows)
    {
        $this->importDataMock->method('getData')->willReturn(array_merge($headers, $rows));

    }

}

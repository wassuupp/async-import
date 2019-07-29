<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */

declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ImportProcessingRuleInterface extends ExtensibleDataInterface
{
    public const SORT = 'sort';
    public const FUNCTION = 'function';
    public const ARGS = 'args';

    /**
     * Retrieve execution position
     *
     * @return integer|null
     */
    public function getSort(): ?int;

    /**
     * Set execution postion
     *
     * @param integer|null $sort
     * @return void
     */
    public function setSort(int $sort): void;

    /**
     * Retrieve function name
     *
     * @return string
     */
    public function getFunction(): ?string;

    /**
     * Set function name
     *
     * @param string $function
     * @return void
     */
    public function setFunction(string $function): void;

    /**
     * Retrieve function arguments
     *
     * @return mixed|null
     */
    public function getArgs(): ?array;

    /**
     * Set function arguments
     *
     * @param mixed $args
     * @return void
     */
    public function setArgs(array $args): void;
}
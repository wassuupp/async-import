<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRuleInterface;

/**
 * @inheritdoc
 */
class ConvertingRule implements ConvertingRuleInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var array
     */
    private $applyTo;

    /**
     * @param string $name
     * @param array $parameters
     * @param int $sort
     * @param string[] $applyTo
     */
    public function __construct(string $name, array $parameters, int $sort, array $applyTo)
    {
        $this->name = $name;
        $this->parameters = $parameters;
        $this->sort = $sort;
        $this->applyTo = $applyTo;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @inheritdoc
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @inheritdoc
     */
    public function getApplyTo(): array
    {
        return $this->applyTo;
    }
}

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
     * @param string $name
     * @param array $parameters
     * @param int $sort
     */
    public function __construct(string $name, array $parameters, int $sort)
    {
        $this->name = $name;
        $this->parameters = $parameters;
        $this->sort = $sort;
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
}

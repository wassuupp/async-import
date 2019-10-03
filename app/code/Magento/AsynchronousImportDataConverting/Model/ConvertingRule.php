<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportDataConverting\Model;

use Magento\AsynchronousImportDataConvertingApi\Api\Data\ConvertingRuleInterface;

/**
 * @inheritdoc
 */
class ConvertingRule implements ConvertingRuleInterface
{
    /**
     * @var string
     */
    private $identifier;

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
     * @param string $identifier
     * @param array $parameters
     * @param int|null $sort
     * @param string[] $applyTo
     */
    public function __construct(string $identifier, array $parameters = [], int $sort = null, array $applyTo = [])
    {
        $this->identifier = $identifier;
        $this->parameters = $parameters;
        $this->sort = $sort;
        $this->applyTo = $applyTo;
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
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
    public function getSort(): ?int
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

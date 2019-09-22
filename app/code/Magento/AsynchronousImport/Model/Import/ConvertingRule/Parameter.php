<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import\ConvertingRule;

use Magento\AsynchronousImportApi\Api\Data\ConvertingRule\ParameterInterface;

/**
 * @inheritdoc
 */
class Parameter implements ParameterInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $value;

    /**
     * Parameter constructor.
     *
     * @param string   $name
     * @param string[] $value
     */
    public function __construct(string $name, array $value = [])
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): array
    {
        return $this->value;
    }
}

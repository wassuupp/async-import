<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportServiceApi\Api\Data\ImportProcessingRuleInterface;
use Magento\ImportServiceApi\Api\Data\ImportProcessingRuleExtensionInterface;

/**
 * Class ImportProcessingRule
 */
class ImportProcessingRule extends AbstractExtensibleModel implements ImportProcessingRuleInterface
{
    /**
     * @inheritDoc
     */
    public function getSort(): ?int
    {
        return $this->getData(self::SORT);
    }
    /**
     * @inheritDoc
     */
    public function setSort(?int $sort): void
    {
        $this->setData(self::SORT, $sort);
    }
    /**
     * @inheritDoc
     */
    public function getFunction(): ?string
    {
        return $this->getData(self::FUNCTION);
    }
    /**
     * @inheritDoc
     */
    public function setFunction(?string $function):void
    {
        $this->setData(self::FUNCTION, $function);
    }
    /**
     * @inheritDoc
     */
    public function getArgs(): ?array
    {
        return $this->getData(self::ARGS);
    }
    /**
     * @inheritDoc
     */
    public function setArgs(?array $args): void
    {
        $this->setData(self::ARGS, $args);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?ImportProcessingRuleExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        ImportProcessingRuleExtensionInterface $extensionAttributes
    ): ImportProcessingRuleInterface {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

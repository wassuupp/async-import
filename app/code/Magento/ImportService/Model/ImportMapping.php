<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportServiceApi\Api\Data\ImportMappingInterface;

/**
 * Class SourceFormatMapping
 */
class ImportMapping extends AbstractModel implements ImportMappingInterface
{
    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getSourceName()
    {
        return self::SOURCE_NAME_PREFIX . '_' . $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getTargetName()
    {
        return self::TARGET_NAME_PREFIX . '_' . $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getSourcePath(): ?string
    {
        return $this->getData(self::SOURCE_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setSourcePath(string $sourcePath): void
    {
        $this->setData(self::SOURCE_PATH, $sourcePath);
    }

    /**
     * @inheritDoc
     */
    public function getTargetPath(): ?string
    {
        return $this->getData(self::TARGET_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setTargetPath(string $targetPath): void
    {
        $this->setData(self::TARGET_PATH, $targetPath);
    }

    /**
     * @inheritDoc
     */
    public function getSourceValue(): ?string
    {
        return $this->getData(self::SOURCE_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceValue(string $sourceValue): void
    {
        $this->setData(self::SOURCE_VALUE, $sourceValue);
    }

    /**
     * @inheritDoc
     */
    public function getTargetValue(): ?string
    {
        return $this->getData(self::TARGET_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setTargetValue(string $targetValue): void
    {
        $this->setData(self::TARGET_VALUE, $targetValue);
    }

    /**
     * @inheritDoc
     */
    public function getProcessingRules(): ?array
    {
        return $this->getData(self::PROCESSING_RULES);
    }

    /**
     * @inheritDoc
     */
    public function setProcessingRules(?array $processingRules): void
    {
        $this->setData(self::PROCESSING_RULES, $processingRules);
    }
}

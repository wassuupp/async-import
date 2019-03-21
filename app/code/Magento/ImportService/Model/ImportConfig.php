<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\ImportConfigExtensionInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;

/**
 * Class ImportConfig
 */
class ImportConfig extends AbstractExtensibleModel implements ImportConfigInterface
{
    /**
     * @inheritdoc
     */
    public function getProfileUuid(): string
    {
        return $this->getData(self::PROFILE_UUID);
    }

    /**
     * @inheritdoc
     */
    public function setProfileUuid(string $profileUuid): void
    {
        $this->setData(self::PROFILE_UUID, $profileUuid);
    }

    /**
     * @inheritdoc
     */
    public function getBehaviour(): string
    {
        return $this->getData(self::BEHAVIOUR);
    }

    /**
     * @inheritdoc
     */
    public function setBehaviour(string $behaviour): void
    {
        $this->setData(self::BEHAVIOUR, $behaviour);
    }

    /**
     * @inheritdoc
     */
    public function getAllowedErrorCount(): int
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setAllowedErrorCount(int $allowedErrorCount): void
    {
        $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * @inheritdoc
     */
    public function getValidationStrategy(): string
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @inheritdoc
     */
    public function setValidationStrategy(string $validationStrategy): void
    {
        $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ImportConfigExtensionInterface
    {
        // TODO: Implement getExtensionAttributes() method.
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(ImportConfigExtensionInterface $extension): void
    {
        // TODO: Implement setExtensionAttributes() method.
    }
}

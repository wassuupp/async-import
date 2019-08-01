<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportServiceApi\Api\Data\ImportProcessingRuleArgumentInterface;

/**
 * Class SourceFormatMapping
 */
class ImportProcessingRuleArgument implements ImportProcessingRuleArgumentInterface
{
    /**
     * @inheritDoc
     */
    public function getValue(): ?string
    {
        return $this->getData(self::VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setValue(?string $value): void
    {
        $this->setData(self::VALUE, $value);
    }

}

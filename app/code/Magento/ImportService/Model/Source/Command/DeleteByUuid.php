<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\Api\Data\SourceCsvInterfaceFactory;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;

/**
 * @inheritdoc
 */
class DeleteByUuid implements DeleteByUuidInterface
{
    /**
     * @var SourceCsvInterfaceFactory
     */
    private $sourceFactory;

    /**
     * @var SourceResourceModel
     */
    private $sourceResource;

    /**
     * @param SourceCsvInterfaceFactory $sourceFactory
     * @param SourceResourceModel $sourceResource
     */
    public function __construct(
        SourceCsvInterfaceFactory $sourceFactory,
        SourceResourceModel $sourceResource
    ) {
        $this->sourceFactory = $sourceFactory;
        $this->sourceResource  = $sourceResource;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $uuid): void
    {
        /** @var SourceCsvInterface $source */
        $source = $this->sourceFactory->create();
        $this->sourceResource->load($source, $uuid, SourceCsvInterface::UUID);

        if (null === $source->getUuid()) {
            throw new NoSuchEntityException(
                __(
                    'There is no source with "%fieldValue" for "%fieldName". Verify and try again.',
                    [
                        'fieldName' => SourceCsvInterface::UUID,
                        'fieldValue' => $uuid
                    ]
                )
            );
        }

        try {
            $this->sourceResource->delete($source);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
    }
}

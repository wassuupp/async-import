<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceApi\Api\SourceBuilderInterfaceFactory;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;

/**
 * @inheritdoc
 */
class DeleteByUuid implements DeleteByUuidInterface
{
    /**
     * @var SourceBuilderInterfaceFactory
     */
    private $sourceFactory;

    /**
     * @var SourceResourceModel
     */
    private $sourceResource;

    /**
     * @param SourceBuilderInterfaceFactory $sourceFactory
     * @param SourceResourceModel $sourceResource
     */
    public function __construct(
        SourceBuilderInterfaceFactory $sourceFactory,
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
        /** @var SourceBuilderInterface $source */
        $source = $this->sourceFactory->create();
        $this->sourceResource->load($source, $uuid, SourceBuilderInterface::UUID);

        if (null === $source->getUuid()) {
            throw new NoSuchEntityException(
                __(
                    'There is no source with "%fieldValue" for "%fieldName". Verify and try again.',
                    [
                        'fieldName' => SourceBuilderInterface::UUID,
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

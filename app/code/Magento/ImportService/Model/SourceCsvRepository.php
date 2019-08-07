<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\ImportServiceApi\Api\Data\SourceInterface;
use Magento\ImportServiceApi\Api\SourceCsvRepositoryInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;
use Magento\ImportService\Model\Source\Command\SaveInterface;
use Magento\ImportService\Model\Source\Command\GetInterface;
use Magento\ImportService\Model\Source\Command\GetListInterface;
use Magento\ImportService\Model\Source\Command\DeleteByUuidInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;

/**
 * Class SourceRepository
 */
class SourceCsvRepository implements SourceCsvRepositoryInterface
{
    /**
     * @var SourceResourceModel
     */
    private $sourceResourceModel;

    /**
     * @var GetListInterface
     */
    private $commandGetList;

    /*
     * @var DeleteByUuidInterface
     */
    private $commandDeleteByUuid;

    /**
     * @var GetInterface
     */
    private $commandGet;

    /**
     * @var SaveInterface
     */
    private $commandSave;

    /**
     * @param SourceResourceModel $sourceResourceModel
     * @param SaveInterface $commandSave
     * @param GetListInterface $commandGetList
     * @param DeleteByUuidInterface $commandDeleteByUuid
     * @param GetInterface $commandGet
     */
    public function __construct(
        SourceResourceModel $sourceResourceModel,
        SaveInterface $commandSave,
        GetListInterface $commandGetList,
        DeleteByUuidInterface $commandDeleteByUuid,
        GetInterface $commandGet
    ) {
        $this->sourceResourceModel  = $sourceResourceModel;
        $this->commandSave = $commandSave;
        $this->commandGetList = $commandGetList;
        $this->commandDeleteByUuid = $commandDeleteByUuid;
        $this->commandGet = $commandGet;
    }

    /**
     * @inheritdoc
     */
    public function save(SourceInterface $source): SourceInterface
    {
        return $this->commandSave->execute($source);
    }

    /**
     * @inheritdoc
     */
    public function getByUuid(string $uuid): SourceInterface
    {
        return $this->commandGet->execute($uuid);
    }

    /**
     * @inheritdoc
     */
    public function deleteByUuid(string $uuid): void
    {
        $this->commandDeleteByUuid->execute($uuid);
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        return $this->commandGetList->execute($searchCriteria);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 * Interface SourceRepositoryInterface
 */
interface SourceRepositoryInterface
{
    /**
     * Save source data
     *
     * @param \Magento\ImportServiceApi\Api\SourceBuilderInterface $source
     * @return \Magento\ImportServiceApi\Api\SourceBuilderInterface
     * @throws CouldNotSaveException
     */
    public function save(SourceBuilderInterface $source): SourceBuilderInterface;

    /**
     * Get source data by given uuid
     *
     * @param string $uuid
     * @return \Magento\ImportServiceApi\Api\SourceBuilderInterface
     * @throws NoSuchEntityException
     */
    public function getByUuid(string $uuid): SourceBuilderInterface;

    /**
     * Find sources by given search criteria. Search criteria is not required.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface;

    /**
     * Delete the source by uuid. If source is not found, NoSuchEntityException is thrown
     *
     * @param string $uuid
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteByUuid(string $uuid): void;
}

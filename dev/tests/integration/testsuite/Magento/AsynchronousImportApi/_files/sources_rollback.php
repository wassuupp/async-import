<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

//use Engine\Location\Api\Data\SourceInterface;
//use Engine\Location\Api\SourceRepositoryInterface;
//use Magento\Framework\Api\SearchCriteriaBuilder;
//use Magento\Framework\Api\SearchCriteriaBuilderFactory;
//use Magento\TestFramework\Helper\Bootstrap;
//
///** @var SourceRepositoryInterface $sourceRepository */
//$sourceRepository = Bootstrap::getObjectManager()->get(SourceRepositoryInterface::class);
///** @var SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory */
//$searchCriteriaBuilderFactory = Bootstrap::getObjectManager()->get(SearchCriteriaBuilderFactory::class);
///** @var SearchCriteriaBuilder $searchCriteriaBuilder */
//$searchCriteriaBuilder = $searchCriteriaBuilderFactory->create();
//
//$searchCriteria = $searchCriteriaBuilder
//    ->addFilter(SourceInterface::CITY_ID, [100, 200, 300, 400], 'in')
//    ->create();
//
//$cities = $sourceRepository->getList($searchCriteria)->getItems();
//foreach ($cities as $source) {
//    $sourceRepository->deleteById((int)$source->getSourceId());
//}

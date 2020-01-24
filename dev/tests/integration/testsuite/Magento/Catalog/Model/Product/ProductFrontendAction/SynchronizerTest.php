<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Catalog\Model\Product\ProductFrontendAction;

use Magento\Catalog\Model\ProductRepository;

/**
 * Test for \Magento\Catalog\Model\Product\ProductFrontendAction\Synchronizer.
 */
class SynchronizerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Synchronizer
     */
    private $synchronizer;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

        $this->synchronizer = $objectManager->get(Synchronizer::class);
        $this->productRepository = $objectManager->get(ProductRepository::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoDataFixture Magento/Catalog/_files/second_product_simple.php
     *
     * @return void
     */
    public function testSyncActions(): void
    {
        $actionsType = 'recently_viewed_product';
        $product1 = $this->productRepository->get('simple');
        $product2 = $this->productRepository->get('simple2');
        $product1Id = $product1->getId();
        $product2Id = $product2->getId();
        $productsData = [
            $product1Id => [
                'added_at' => '1576582660',
                'product_id' => $product1Id,
            ],
            $product2Id => [
                'added_at' => '1576587153',
                'product_id' => $product2Id,
            ],
        ];

        $this->synchronizer->syncActions($productsData, $actionsType);

        $synchronizedCollection = $this->synchronizer->getActionsByType($actionsType);
        $synchronizedCollection->addFieldToFilter(
            'product_id',
            [
                $product1Id,
                $product2Id,
            ]
        );

        foreach ($synchronizedCollection as $item) {
            $this->assertArrayHasKey($item->getProductId(), $productsData);
            $this->assertEquals($productsData[$item->getProductId()]['added_at'], $item->getAddedAt());
        }
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoDataFixture Magento/Catalog/_files/second_product_simple.php
     *
     * @return void
     */
    public function testSyncActionsWithoutActionsType(): void
    {
        $product1 = $this->productRepository->get('simple');
        $product2 = $this->productRepository->get('simple2');
        $product1Id = $product1->getId();
        $product2Id = $product2->getId();
        $productsData = [
            $product1Id => [
                'id' => $product1Id,
                'name' => $product1->getName(),
                'type' => $product1->getTypeId(),
            ],
            $product2Id => [
                'id' => $product2Id,
                'name' => $product2->getName(),
                'type' => $product2->getTypeId(),
            ],
        ];

        $this->synchronizer->syncActions($productsData, '');
    }
}

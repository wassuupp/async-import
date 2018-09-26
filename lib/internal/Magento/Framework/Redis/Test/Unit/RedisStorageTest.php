<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Redis\Test\Unit;

use Magento\Framework\Redis\RedisConnectionInterface;
use Magento\Framework\Redis\RedisStorage;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RedisStorageTest extends TestCase
{
    private const TEST_KEY = 'testKey';
    /**
     * @var RedisConnectionInterface|MockObject
     */
    private $redisConnection;

    /**
     * @var \Credis_Client|MockObject
     */
    private $redisClient;

    /**
     * @var \Credis_Client|MockObject
     */
    private $pipeline;

    /**
     * @var RedisStorage
     */
    private $redisStorage;

    protected function setUp()
    {
        $this->redisConnection = $this->getMockBuilder(RedisConnectionInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getClient'])
            ->getMock();
        $this->redisClient = $this->getMockBuilder(\Credis_Client::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'get',
                'set',
                'del',
                'exists',
                'pipeline',
            ])
            ->getMockForAbstractClass();
        $this->pipeline = $this->getMockBuilder(\Credis_Client::class)
            ->setMethods([
                'exec',
                'sAdd',
                'sRem',
            ])
            ->getMockForAbstractClass();

        $this->redisConnection
            ->expects($this->once())
            ->method('getClient')
            ->willReturn($this->redisClient);

        $objectManager = new ObjectManager($this);
        $this->redisStorage = $objectManager->getObject(RedisStorage::class, [
            'redisConnection' => $this->redisConnection
        ]);
    }

    public function testGet()
    {
        $this->redisClient
            ->expects($this->once())
            ->method('get')
            ->with(static::TEST_KEY)
            ->willReturn('42');

        $this->assertEquals('42', $this->redisStorage->get(static::TEST_KEY));
    }

    public function testAdd()
    {
        $this->redisClient
            ->expects($this->once())
            ->method('exists')
            ->with(static::TEST_KEY)
            ->willReturn(false);

        $this->redisClient
            ->expects($this->once())
            ->method('set')
            ->with(static::TEST_KEY)
            ->willReturn(1);

        $this->assertEquals($this->redisStorage, $this->redisStorage->add(static::TEST_KEY, '42'));
    }

    public function testUpdate()
    {
        $this->redisClient
            ->expects($this->once())
            ->method('exists')
            ->with(static::TEST_KEY)
            ->willReturn(true);

        $this->redisClient
            ->expects($this->once())
            ->method('set')
            ->with(static::TEST_KEY)
            ->willReturn(1);

        $this->assertEquals($this->redisStorage, $this->redisStorage->update(static::TEST_KEY, '42'));
    }

    public function testDelete()
    {
        $this->redisClient
            ->expects($this->once())
            ->method('exists')
            ->with(static::TEST_KEY)
            ->willReturn(true);

        $this->redisClient
            ->expects($this->once())
            ->method('del')
            ->with(static::TEST_KEY)
            ->willReturn(1);

        $this->assertEquals($this->redisStorage, $this->redisStorage->delete(static::TEST_KEY));
    }

    public function testAddTags()
    {
        $tags = [
            '42',
            '37'
        ];

        $this->redisClient
            ->expects($this->once())
            ->method('pipeline')
            ->willReturn($this->pipeline);

        $this->pipeline
            ->expects($this->exactly(count($tags)))
            ->method('sAdd')
            ->withConsecutive(
                [static::TEST_KEY, '42'],
                [static::TEST_KEY, '37']
            );

        $this->pipeline
            ->expects($this->once())
            ->method('exec');

        $this->assertEquals($this->redisStorage, $this->redisStorage->addTags(static::TEST_KEY, $tags));
    }

    public function testRemoveTags()
    {
        $tags = [
            '42',
            '37'
        ];

        $this->redisClient
            ->expects($this->once())
            ->method('pipeline')
            ->willReturn($this->pipeline);

        $this->pipeline
            ->expects($this->exactly(count($tags)))
            ->method('sRem')
            ->withConsecutive(
                [static::TEST_KEY, '42'],
                [static::TEST_KEY, '37']
            );

        $this->pipeline
            ->expects($this->once())
            ->method('exec');

        $this->assertEquals($this->redisStorage, $this->redisStorage->removeTags(static::TEST_KEY, $tags));
    }
}

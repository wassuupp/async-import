<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento\Framework\Redis;

use Magento\Framework\KeyValue\KeyValueStorageException;
use Magento\Framework\KeyValue\KeyValueStorageInterface;
use Magento\Framework\KeyValue\TaggableKeyValueStorageInterface;

class RedisStorage implements TaggableKeyValueStorageInterface
{
    /**
     * @var RedisConnectionInterface
     */
    private $redisConnection;

    /**
     * @param RedisConnectionInterface $redisConnection
     */
    public function __construct(RedisConnectionInterface $redisConnection)
    {
        $this->redisConnection = $redisConnection;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key): string
    {
        $client = $this->redisConnection->getClient();

        return (string)$client->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $key, string $value): KeyValueStorageInterface
    {
        $client = $this->redisConnection->getClient();
        if ($client->exists($key)) {
            throw new KeyValueStorageException(__('Key %1 already exists', $key));
        }

        $client->set($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $key, string $value): KeyValueStorageInterface
    {
        $client = $this->redisConnection->getClient();
        if (!$client->exists($key)) {
            throw new KeyValueStorageException(__('Unable to update non-existing key %1', $key));
        }

        $client->set($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $key): KeyValueStorageInterface
    {
        $client = $this->redisConnection->getClient();
        if (!$client->exists($key)) {
            throw new KeyValueStorageException(__('Unable to delete non-existing key %1', $key));
        }

        $client->del($key);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getByTags(array $tags): array
    {
        $client = $this->redisConnection->getClient();

        return array_map(function (string $tag) use ($client) {
            return $client->get($tag);
        }, $tags);
    }


    /**
     * {@inheritdoc}
     */
    public function addTags(string $key, array $tags): TaggableKeyValueStorageInterface
    {
        $client = $this->redisConnection->getClient();
        $pipeline = $client->pipeline();
        array_map(function (string $tag) use ($pipeline, $key) {
            $pipeline->sAdd($key, $tag);
        }, $tags);
        $pipeline->exec();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTags(string $key, array $tags): TaggableKeyValueStorageInterface
    {
        $client = $this->redisConnection->getClient();

        $pipeline = $client->pipeline();
        array_map(function (string $tag) use ($pipeline, $key) {
            $pipeline->sRem($key, $tag);
        }, $tags);

        $pipeline->exec();

        return $this;
    }
}

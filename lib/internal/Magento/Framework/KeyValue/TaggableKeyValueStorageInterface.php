<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\KeyValue;

/**
 * Extend key-value storage interface with tag-related functionality
 */
interface TaggableKeyValueStorageInterface extends KeyValueStorageInterface
{
    /**
     * Add a new item to the storage (optionally, add tags to them), throw an exception if the record exists.
     *
     * @param string $key
     * @param string $value
     * @param string[] $tags
     * @return void
     * @throws KeyValueStorageException
     */
    public function add(string $key, string $value, array $tags = []);

    /**
     * Return values by tags
     *
     * @param string[] $tags
     * @return string[]
     */
    public function getByTags(array $tags): array;

    /**
     * Add tags to an item. If not all tags were added - throw an exception.
     *
     * @param string $key
     * @param string[] $tags
     * @return void
     * @throws KeyValueStorageException
     */
    public function addTagsToItem(string $key, array $tags);

    /**
     * Remove all, throw exception otherwise.
     *
     * @param string $key
     * @param array $tags
     * @return void
     * @throws KeyValueStorageException
     */
    public function removeTagsFromItem(string $key, array $tags);

    /**
     * Remove a tag from all items.
     *
     * @param string $tag
     * @return void
     */
    public function removeTag(string $tag);
}

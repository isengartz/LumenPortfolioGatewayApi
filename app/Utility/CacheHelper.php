<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 7/6/2020
 * Time: 2:18 πμ
 */

namespace App\Utility;


use Illuminate\Redis\RedisManager;

/**
 * Class CacheHelper
 * @package App\Utility
 */
class CacheHelper
{
    /**
     * @var RedisManager
     */
    protected $cacher;

    /**
     * CacheHelper constructor.
     * @param RedisManager $redisManager
     */
    public function __construct(RedisManager $redisManager)
    {
        $this->cacher = $redisManager;
    }

    /**
     * Cache a single Entity.
     * @param string $key
     * @param $value
     */
    public function cacheEntity(string $key, $value)
    {
        $this->cacher->set($key, $value);
    }

    /**
     * Cache a hash entity.
     * @param string $key
     * @param $identifier
     * @param $value
     */
    public function cacheCollection(string $key, $identifier, $value)
    {
        $this->cacher->hmset($key, $identifier, $value);
    }

    /**
     * Check if entity is cached
     * @param string $key
     * @return mixed
     */
    public function cacheEntityExists(string $key)
    {
        return $this->cacher->exists($key);
    }

    /**
     * Returns a single simple cached entity
     * @param string $key
     * @return mixed
     */
    public function getCachedEntity(string $key)
    {
        return $this->cacher->get($key);
    }

    /**
     * Returns a single item from a cached hash entity
     * @param string $key
     * @param $identifierValue
     * @return mixed
     */
    public function getCachedCollectionEntity(string $key, $identifierValue)
    {
        return $this->cacher->hmget($key, $identifierValue);
    }

    /**
     * Returns a cached hash entity
     * @param string $key
     * @return mixed
     */
    public function getCachedCollection(string $key)
    {
        return $this->cacher->hgetall($key);
    }

    /**
     * Helper that caches each item from a hash cache entity
     * @param array $data
     * @param string $identifierField
     * @param $key
     * @param bool $single
     */
    public function cacheCollectionHelper(array $data, string $identifierField, $key, $single = false)
    {
        // if we cache a single item . Used for Edit
        if ($single) {
            $this->cacheCollection($key, $data[$identifierField], json_encode($data));
        } else { // If we cache the whole collection
            foreach ($data as $item) {
                $this->cacheCollection($key, $item[$identifierField], json_encode($item));
            }
        }

    }

    /**
     * Deletes a single item from the hash
     * @param string $key
     * @param $identifier
     */
    public function deleteCollectionItem(string $key, $identifier)
    {
        $this->cacher->hdel($key, $identifier);
    }

    /**
     * Delete whole hash collection
     * @param string $key
     */
    public function deleteCollection(string $key)
    {
        $this->cacher->del($key);
    }

}

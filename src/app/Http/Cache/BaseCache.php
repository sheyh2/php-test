<?php

namespace App\Http\Cache;

use ErrorException;

/**
 * Class BaseCache.php
 * @package App\Http\Cache
 */
abstract class BaseCache
{
    public function __construct()
    {
    }

    public int $minute = 60;

    /**
     * @throws ErrorException
     */
    public function cacheAdd(string $key, $values, int $ttl)
    {
        if (apcu_exists($key)) {
            throw new ErrorException("Cache with {$key} key already exists");
        }

        $added = apcu_add($key, $values, $ttl);

        if (!$added) {
            throw new ErrorException("Cache with {$key} key already exists");
        }
    }

    /**
     * @throws ErrorException
     */
    public function cacheStore(string $key, $values, int $ttl)
    {
        $added = apcu_store($key, $values, $ttl);

        if (!$added) {
            throw new ErrorException("Cache with {$key} key already exists");
        }
    }

    public function cacheFetch(string $key)
    {
        $data = apcu_fetch($key, $success);
        if (!$success) {
            return null;
        }

        return $data;
    }
}
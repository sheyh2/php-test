<?php

namespace App\Http\Cache;

/**
 * Class Cache.php
 * @package App\Http\Cache
 */
class Cache extends BaseCache
{
    public static function getInstance(): Cache
    {
        return new static();
    }
}
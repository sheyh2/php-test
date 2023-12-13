<?php

namespace App\Http\Cache;

use ErrorException;

/**
 * Class CommentCache.php
 * @package App\Http\Cache
 */
class CommentCache extends BaseCache
{
    public function __construct()
    {
        parent::__construct();

        $this->baseKey = 'CommentCache@%s';
    }

    private string $baseKey;

    public static function getInstance(): CommentCache
    {
        return new static();
    }

    /**
     * @param $values
     * @return void
     * @throws ErrorException
     */
    public function cacheComment($values)
    {
        $key = sprintf($this->baseKey, 'commentCache');

        parent::cacheAdd($key, $values, $this->minute);
    }

    public function getComment()
    {
        $key = sprintf($this->baseKey, 'getComment');

        return parent::cacheFetch($key);
    }
}
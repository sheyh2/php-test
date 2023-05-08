<?php

namespace App\Models;

/**
 * Class Comment.php
 * @package App\Models
 */
class Comment extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    protected string $table = 'comments';

    public static function getInstance(): Comment
    {
        return new static();
    }

    public function getItems(): array|null
    {
        return parent::getAll();
    }

    public function insertItem($items): bool
    {
        return parent::insertInto($items);
    }
}
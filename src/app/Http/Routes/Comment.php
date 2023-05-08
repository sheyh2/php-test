<?php

namespace App\Http\Routes;

use App\Http\Controllers\CommentController;

/**
 * Class Comment.php
 * @package App\Http\Routes
 */
class Comment
{
    public function list(): bool|string
    {
        return CommentController::getInstance()->list();
    }

    public function store(): bool|string
    {
        return CommentController::getInstance()->store(request());
    }
}
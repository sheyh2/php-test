<?php

namespace App\Http\Routes;

use App\Http\Controllers\CommentController;

/**
 * Class Comment.php
 * @package App\Http\Routes
 */
class Comment
{
    public function list()
    {
        return CommentController::getInstance()->list();
    }

    public function store()
    {
        return CommentController::getInstance()->store(request());
    }
}
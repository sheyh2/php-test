<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\Comment;

/**
 * Class CommentController.php
 * @package App\Http\Controllers
 */
class CommentController extends ApiController
{
    public static function getInstance(): CommentController
    {
        return new static();
    }

    public function list(): bool|string
    {
        return $this->composJson(Comment::getInstance()->getItems());
    }

    public function store(Request $request): bool|string
    {
        $fails = !$request->valid([
            'name',
            'comment',
        ]);

        if ($fails) {
            $this->setStatus(false);
            $this->setCode(400);
            $this->setMessage('Bad request');

            return $this->composJson();
        }

        $items = [
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
        ];

        if (!Comment::getInstance()->insertItem($items)) {
            $this->setStatus(false);
            $this->setCode(400);
            $this->setMessage('Something is missing. Try again!');

            return $this->composJson();
        }

        return $this->composJson();
    }
}
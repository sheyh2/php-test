<?php

namespace App\Http\Controllers;

use App\Http\Cache\Cache;
use App\Http\Cache\CommentCache;
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

    public function list()
    {
        return $this->composJson(Comment::getInstance()->getItems());
    }

    public function store(Request $request)
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

        if (!$this->throttle()) {
            $this->setStatus(false);
            $this->setCode(429);
            $this->setMessage('Too many request!');

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

    public function throttle(): bool
    {
        $cache = Cache::getInstance();
        $attempts = (int)$cache->cacheFetch(request()->ip());
        if ($attempts < 5) {
            $attempts++;
            $cache->cacheStore(request()->ip(), $attempts, $cache->minute);
            return true;
        }
        return false;
    }
}
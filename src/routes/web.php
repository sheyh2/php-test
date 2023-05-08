<?php

use App\Http\Routes\Comment;
use App\Http\Routes\RouteRegister;

header("Access-Control-Allow-Origin: *");

$registerRoute = new RouteRegister($_SERVER);

$registerRoute->get('/api/comment/list', [Comment::class, 'list']);
$registerRoute->post('/api/comment/store', [Comment::class, 'store']);
echo $registerRoute->init();
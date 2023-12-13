<?php

use App\Http\Requests\Request;

if (!function_exists('dd')) {
    function dd($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);

        exit();
    }
}

if (!function_exists('request')) {
    function request(): Request
    {
        return new Request();
    }
}

function session()
{
    session_start();
}

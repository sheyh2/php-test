<?php

namespace App\Http\Requests;

/**
 * Class Request.php
 * @package App\Http\Requests
 */
class Request
{
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->requestData = array_merge($this->get, $this->post);
    }

    private array $get;
    private array $post;
    private array $server;
    private array $requestData;

    public function query(string $name, $default = null)
    {
        return $this->get[$name] ?? $default;
    }

    public function input(string $name, $default = null)
    {
        return $this->requestData[$name] ?? $default;
    }

    public function all(): array
    {
        return $this->requestData;
    }

    public function valid(array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!isset($this->requestData[$rule])) {
                return false;
            }
        }

        return true;
    }

    public function ip(): string
    {
        return $this->server['HTTP_X_FORWARDED_FOR'];
    }
}
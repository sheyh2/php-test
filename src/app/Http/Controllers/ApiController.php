<?php

namespace App\Http\Controllers;

/**
 * Class ApiController.php
 * @package App\Http\Controllers
 */
class ApiController
{
    public function __construct()
    {
    }

    private bool $status = true;
    private int $code = 200;
    private string $message = 'ok';

    public function composJson($resource = []): bool|string
    {
        $data = [
            'status' => $this->status,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $resource,
        ];

        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
<?php

namespace App\Http\Responses;

class ApiResponse
{
    protected $success;
    protected $code;
    protected $data;
    protected $payload;

    public function __construct()
    {
        $this->success = true;
        $this->code = 200;
        $this->data = null;

        $this->payload = [
            'success' => $this->success,
            'code' => $this->code,
            'data' => $this->data
        ];
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setCode($code = null)
    {
        $this->code = $code ?: $this->code;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setPayload($data, $code = null)
    {
        $this->payload['code'] = $code ?: $this->code;
        $this->payload['data'] = $data;
    }
}

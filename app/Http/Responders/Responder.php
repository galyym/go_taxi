<?php

namespace App\Http\Responders;

class Responder
{
    public function __construct()
    {
    }
    private function respond($success, $message, $data = [], $statusCode)
    {
        return response()->json([
            "success" => $success,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }
    public function success($message = null, $data = [] , $statusCode = 200)
    {
        return $this->respond(true, $message, $data, $statusCode);
    }

    public function error($message, $data = [], $statusCode = 404)
    {
        return $this->respond(false, $message, $data, $statusCode);
    }
}

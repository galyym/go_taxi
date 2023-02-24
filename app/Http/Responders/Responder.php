<?php

namespace App\Http\Responders;

use Illuminate\Http\JsonResponse;

class Responder
{
    public function __construct()
    {
    }

    /**
     * @param $success
     * @param $message
     * @param $data
     * @param $statusCode
     * @return JsonResponse
     */
    private function respond($success, $message, $data = [], $statusCode)
    {
        return response()->json([
            "success" => $success,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }
    public function success($message = null, $data = [], $statusCode = 200)
    {
        return $this->respond(true, $message, $data, $statusCode);
    }

    public function error($message, $data = [], $statusCode = 404)
    {
        return $this->respond(false, $message, $data, $statusCode);
    }
}

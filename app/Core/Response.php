<?php

namespace app\Core;

use app\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    public static function send(
        $data = null,
        $id = null,
        $userId = null,
        $statusCode = 200
    ): void {
        header_remove();
        http_response_code($statusCode);
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode([
            'status_code' => $statusCode,
            'id' => $id,
            'user_id' => $userId,
            'data' => $data,
        ]);
        exit();
    }
}

<?php

class Response
{
    const HTTP_RESPONSE_CODE = [
        200 => [
            'status' => true,
            'header' => 'HTTP/1.1 200 OK'
        ],
        201 => [
            'status' => true,
            'header' => 'HTTP/1.1 201 Created'
        ],
        204 => [
            'status' => true,
            'header' => 'HTTP/1.1 204 No Content'
        ],
        400 => [
            'status' => false,
            'header' => 'HTTP/1.1 400 Bad Request'
        ],
        401 => [
            'status' => false,
            'header' => 'HTTP/1.1 401 Unauthorized'
        ],
        403 => [
            'status' => false,
            'header' => 'HTTP/1.1 403 Forbidden'
        ],
        404 => [
            'status' => false,
            'header' => 'HTTP/1.1 404 Not Found'
        ],
        405 => [
            'status' => false,
            'header' => 'HTTP/1.1 405 Method Not Allowed'
        ],
        500 => [
            'status' => false,
            'header' => 'HTTP/1.1 500 Internal Server Error'
        ],
    ];

    private static $is_api = false;

    public static function setApi()
    {
        self::$is_api = true;
    }

    public static function isApi()
    {
        return self::$is_api;
    }

    private static function send(int $statusCode, string $message = '', array $data = [])
    {
        $httpStatus = self::HTTP_RESPONSE_CODE[$statusCode];
        header($httpStatus['header']);
        if (self::$is_api) {
            header('Content-Type: application/json; charset=utf-8');
        } else {
            header('Content-Type: text/html');
        }
        echo json_encode([
            'success' => $httpStatus['status'],
            'message' => $message,
            'data' => $data
        ]);
        exit(0);
    }

    public static function html(string $html = '')
    {
        header(self::HTTP_RESPONSE_CODE[200]['header']);
        header('Content-Type: text/html');
        echo $html;
        exit(0);
    }

    public static function success(string $message = '', array $data = [])
    {
        self::send(200, $message, $data);
    }

    public static function created(string $message = '', array $data = [])
    {
        self::send(201, $message, $data);
    }

    public static function badRequest(string $message = '', array $data = [])
    {
        self::send(400, $message, $data);
    }
}

<?php
namespace App\Utils;

class ResponseModel{

    public static $response;
    
    public static function JsendResponse($status, $data){
        self::$response = new \stdClass();
        self::$response->status = $status;

        if ($status != "success") {
            self::$response->message = $data;
        } else {
            self::$response->data = $data;
        }

        return json_encode(self::$response);
    }
}
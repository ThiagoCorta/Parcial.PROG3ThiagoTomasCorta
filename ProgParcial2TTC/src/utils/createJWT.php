<?php

namespace App\Utils;
use \Firebase\JWT\JWT;

class CreateJWT{
    static public function GenerarTokenJWTPassword($password_a_encriptar){
        $key = "Password";
        $payload = array($password_a_encriptar);
        $password_jwt = JWT::encode($payload, $key);
        return $password_jwt;
    }

    static public function GenerarTokenJWTHeader($userData, $password){
        $key = "Parcial2ThiagoCorta";
        $payload = array(
            'id' => $userData->id,
            'email' => $userData->email,
            'tipo' => $userData->tipo,
            'clave' => $password,
            'usuario' => $userData->usuario,
        );
        $jwt = JWT::encode($payload, $key);
        $rta = ResponseModel::JsendResponse("success", array("token" => $jwt));
        return $rta;
    }
}
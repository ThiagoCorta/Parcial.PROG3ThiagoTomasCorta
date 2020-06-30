<?php

namespace App\Utils;
use \Firebase\JWT\JWT;
use App\Utils\CreateJWT;

class ValidarUserData{
    
    static public function RegistroUsuario($usuario, $datosPostSinValidar){
        $usuario->email = $datosPostSinValidar['email'] ?? '';
        $tipo = $datosPostSinValidar['tipo'] ?? '';
        $clave = $datosPostSinValidar['clave'] ?? '';
        $usuario->usuario = $datosPostSinValidar['usuario'] ?? '';
        if((($tipo == 1) || ($tipo == 2) || ($tipo == 3))) $usuario->tipo = $tipo;
        $usuario->clave = CreateJWT::GenerarTokenJWTPassword($clave);
        return $usuario;
    }
    
    static public function LoginUsuario($usuario, $clave){
        try {
            $claveDeco = JWT::decode($usuario->clave, 'Password', array('HS256'))[0];
            if($claveDeco == $clave){
                $response = CreateJWT::GenerarTokenJWTHeader($usuario, $claveDeco);
            } else {
                $response = ResponseModel::JsendResponse('error','Clave incorrecta');
            }
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

        return $response;
    }
}
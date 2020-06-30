<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;
use App\Utils\ResponseModel;
use App\Utils\validarUserData;
use Config\Database;
use \Firebase\JWT\JWT;

class UsuariosController {

    public function registro(Request $request, Response $response, $args){
        $usuario = new Usuario();
        $allUsers = Usuario::all();
        $userExist = false;
        $datosARegistrar = $request->getParsedBody() ?? [];
        
        foreach ($allUsers as $key => $value) {
            if($value->email === $datosARegistrar['email']) {
                $res = ResponseModel::JsendResponse('Error','El usuario ya existe');
                $userExist = true;
            }
        }
        if(empty($datosARegistrar)){
            $rta = ResponseModel::JsendResponse('Error','No se recibieron datos para registrar');
        } else if ($userExist == false){
            $usuario = ValidarUserData::RegistroUsuario($usuario, $datosARegistrar);
            $res = ResponseModel::JsendResponse('Registro Usuario',(($usuario->save()) ? 'success' : 'error'));
        }

         
        $response->getBody()->write($res);
        return $response;
    }

    public function login(Request $request, Response $response, $args){

        $datosAValidar = $request->getParsedBody() ?? [];
        
        if(empty($datosAValidar)){  
            $rta = ResponseModel::JsendResponse('LOGIN Usuario ERROR','No se recibieron datos para loguear');
        } else {
            $email_recibido = $datosAValidar['email'];
            $password_recibido = $datosAValidar['clave'];
            if(($email_recibido != '') && $password_recibido != '') {
                $usuario_leidoSQL = Usuario::all()->where('email',$email_recibido)->first();
                $rta = ValidarUserData::LoginUsuario($usuario_leidoSQL, $password_recibido);
            }
        }
        $response->getBody()->write($rta);
        return $response;
    }
}
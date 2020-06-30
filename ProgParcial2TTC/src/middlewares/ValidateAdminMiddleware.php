<?php
namespace App\Middleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Utils\ResponseModel;
use \Firebase\JWT\JWT;

class ValidateAdminMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
        $response = new Response();
        try{
           $tokenExist = false;
            $headers = $request->getHeaders();
            foreach ($headers as $key => $value) {
                if($key == 'token'){
                   $tokenExist = true;
                    break;
                }
            }
            if($tokenExist){
                $token = $request->getHeaders()['token'][0];
                if($token != ''){
                    $user = JWT::decode($token, "Parcial2ThiagoCorta", array('HS256'));
                    if($user->tipo == 1){
                        $response->getBody()->write($existingContent);
                    }else {
                        $response->getBody()->write(ResponseModel::JsendResponse('error','No sos admin no podes estar aca'));
                    }
                } else {
                    $response->getBody()->write(ResponseModel::JsendResponse('error','No existe el token'));
                }
            } else {
                $response->getBody()->write(ResponseModel::JsendResponse('error','No hay token en el header'));
            }
        } catch (\Throwable $e) {
            $response = new Response();
            $response->getBody()->write(ResponseModel::JsendResponse('error','El token esta mal'));
            return $response;
        }
    
        return $response;
    }
}
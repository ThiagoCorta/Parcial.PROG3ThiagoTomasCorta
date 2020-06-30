<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Mascota;
use App\Models\TipoMascota;
use App\Utils\ResponseModel;

class MascotasController {

    public function handleMascotas(Request $request, Response $response, $args){
        $mascota = new Mascota();
        $data = $request->getParsedBody();
        $mascota->nombre = $data['nombre'];
        $mascota->fecha_nacimiento = new \DateTime($data['fecha_nacimiento']);
        $mascota->cliente_id = $data['cliente_id'];
        $mascota->tipo_mascota_id = $data['tipo_mascota_id'];
        $res = ResponseModel::JsendResponse('Registro Mascota',($mascota->save()) ? 'success' : 'Error');
        $response->getBody()->write($res);
        return $response;
    }

  
    public function registrarTipoMascota(Request $request, Response $response, $args){
        $tipoMascota = new TipoMascota();
        $allMascotas = TipoMascota::all();
        $mascotaExist = false;
        $data = $request->getParsedBody() ?? [];
        $tipoMascota->tipo = $data['tipo'];
        foreach ($allMascotas as $key => $value) {
            if($value->tipo ===  $tipoMascota->tipo) {
                $res = ResponseModel::JsendResponse('Error','La mascota ya existe');
                $mascotaExist = true;
            }
        }
        if($mascotaExist == false){
           $res = ResponseModel::JsendResponse('Registro Mascota Tipo Mascota',($tipoMascota->save()) ? 'success' : 'Error');
        }
        $response->getBody()->write($res);
        return $response;
    }


}
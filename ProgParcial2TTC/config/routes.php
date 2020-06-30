<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;
use App\Controllers\MascotasController;
use App\Middleware\TokenValidateMiddleware;
use App\Middleware\ValidateAdminMiddleware;

return function($app){

    $app->post('/registro', UsuariosController::class.':registro');
    $app->post('/login', UsuariosController::class.':login');
    $app->post('/tipo_mascota', MascotasController::class.':registrarTipoMascota')->add(new ValidateAdminMiddleware());
    $app->post('/mascotas', MascotasController::class.':handleMascotas')->add(new TokenValidateMiddleware());
   
};
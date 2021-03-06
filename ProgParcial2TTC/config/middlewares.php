<?php
use Slim\App;
use App\Middleware\JsonConvertResponseMiddleware;

return function(App $app){
    $app->addBodyParsingMiddleware();

    $app->add(new JsonConvertResponseMiddleware());
};
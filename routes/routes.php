<?php
/* Include controller path */
use App\Controllers\UserController;

/* define route */
$app->get('/test', UserController::class . ':read');


/* user group route*/
$app->group('/users', function (){

    $this->get('', UserController::class . ':getAll');
    $this->get('/{id}', UserController::class . ':show');
    $this->post('', UserController::class . ':create');
    $this->map(['PUT','PATCH'], '/{id}', UserController::class . ':update');
    $this->delete('/{id}', UserController::class . ':delete');


});



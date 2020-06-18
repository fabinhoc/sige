<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;

// Client routes
$router->group(['middleware' => 'jwt-auth'], function () use ($router) {
    $router->get('clients', 'ClientController@index');
    $router->get('clients/{id}', 'ClientController@show');
    $router->post('clients', 'ClientController@store');
    $router->put('clients/{id}', 'ClientController@update');
    $router->delete('clients/{id}', 'ClientController@destroy');
});
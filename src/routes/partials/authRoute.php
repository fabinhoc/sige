<?php 

/** @var \Laravel\Lumen\Routing\Router $router */

// auth routes
$router->post('login', 'AuthController@login');
$router->group(['middleware' => 'jwt-auth'], function () use ($router) {
    
    $router->post('logout', 'AuthController@logout');
    $router->post('me', 'AuthController@me');
    $router->post('refresh', 'AuthController@refresh');

});
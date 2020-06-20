<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

// user routes
$router->group(['middleware' => 'jwt-auth'], function () use ($router) {

    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->post('users', function(Request $request) {

        $rules = [
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'name' => 'required'
        ];

        $resource = new UserController();
        return $resource->store($request, $rules);
    
    });
    
    $router->put('users/{id}', 'UserController@update');
    $router->delete('users/{id}', 'UserController@destroy');
    
});
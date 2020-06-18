<?php

/** @var Illuminate\Support\Facades\Route $router */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

$router->post('login', 'AuthController@login');

$router->group(['middleware' => 'jwt-auth'], function () use ($router) {
    
    // auth routes
    $router->post('logout', 'AuthController@logout');
    $router->post('me', 'AuthController@me');
    $router->post('refresh', 'AuthController@refresh');
    
    // user routes
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
    
    $router->put('users/{id}', function(Request $request) {

        $rules = [
            'email' => 'unique:users'
        ];
       
        $resource = new UserController();
        $id = $request->id;
        return $resource->update($id, $request, $rules);
    });
});
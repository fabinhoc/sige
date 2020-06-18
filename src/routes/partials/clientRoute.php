<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;

// Client routes
$router->group(['middleware' => 'jwt-auth'], function () use ($router) {
    $router->get('clients', 'ClientController@index');
    $router->post('clients', function(Request $request){
        $rules = [
            'email' => 'required|unique:clients|email',
            'name' => 'required'
        ];

        $resource = new ClientController();
        return $resource->store($request, $rules);

    });
    $router->get('clients/{id}', 'ClientController@show');
    $router->put('clients/{id}', function(Request $request){
        $rules = [
            'email' => 'unique:clients|email'
        ];

        $resource = new ClientController();
        $id = $request->id;
        return $resource->update($id, $request, $rules);

    });
    $router->delete('clients/{id}', 'ClientController@destroy');
});
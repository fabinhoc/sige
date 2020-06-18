<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use App\Http\Controllers\CompanyController;

// company routes
$router->group(['middleware' => 'jwt-auth'], function () use ($router) {

    $router->get('companies', 'CompanyController@index');
    $router->get('companies/{id}', 'CompanyController@show');
    $router->post('companies', function(Request $request) {

        $rules = [
            'email' => 'required|unique:companies|email',
            'website' => 'required',
            'name' => 'required'
        ];

        $resource = new CompanyController();
        return $resource->store($request, $rules);

    });

    $router->put('companies/{id}', function(Request $request) {

        $rules = [
            'email' => 'unique:companies'
        ];
    
        $resource = new CompanyController();
        $id = $request->id;
        return $resource->update($id, $request, $rules);
    });

});
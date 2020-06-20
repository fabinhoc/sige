<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use App\Http\Controllers\CompanyController;

// company routes
$router->group(['middleware' => 'jwt-auth'], function () use ($router) {
    $router->get('companies', 'CompanyController@index');
    $router->get('companies/{id}', 'CompanyController@show');
    $router->post('companies', 'CompanyController@store');
    $router->post('companies/{id}', 'CompanyController@update');
    $router->delete('companies/{id}', 'CompanyController@destroy');
    $router->get('companies/image/{file}', 'CompanyController@image');
});

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/ministers','MinistersController@index');

$router->post('/ministers','MinistersController@store');

$router->put('/ministers/{id}','MinistersController@update');

$router->post('/product/category', 'ProductCategoriesController@store');
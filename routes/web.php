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

//Minister Routes
$router->get('ministers','MinistersController@index');

$router->post('ministers/check/name', 'MinistersController@checkNameTaken');

$router->post('ministers','MinistersController@store');

$router->put('ministers/{id}','MinistersController@update');

$router->put('ministers/status/{id}', 'MinistersController@changeStatus');


//Baptism Routes
$router->get('baptism','BaptismController@index');

$router->post('baptism','BaptismController@store');

$router->put('baptism/{id}','BaptismController@update');

$router->post('baptism/sponsor/{id}','BaptismController@addSponsor');

$router->put('baptism/sponsor/{id}','BaptismController@updateSponsor');

$router->post('baptism/sponsor/remove/{id}','BaptismController@removeSponsor');

//Confirmation Routes
$router->get('confirmation','ConfirmationController@index');

$router->post('confirmation','ConfirmationController@store');

$router->put('confirmation/{id}','ConfirmationController@update');

$router->post('confirmation/sponsor/{id}','ConfirmationController@addSponsor');

$router->put('confirmation/sponsor/{id}','ConfirmationController@updateSponsor');

$router->post('confirmation/sponsor/remove/{id}','ConfirmationController@removeSponsor');

//Death Routes
$router->get('death','DeathController@index');

$router->post('death','DeathController@store');

$router->put('death/{id}','DeathController@update');

//Marriage Routes

$router->get('marriage','MarriageController@index');

$router->post('marriage','MarriageController@store');

$router->put('marriage/husband/{id}','MarriageController@updateHusband');

$router->put('marriage/wife/{id}','MarriageController@updateWife');

$router->put('marriage/{id}','MarriageController@updateMarriage');

$router->post('marriage/sponsor/{id}','MarriageController@addSponsor');

$router->put('marriage/sponsor/{id}', 'MarriageController@updateSponsor');

$router->post('marriage/sponsor/remove/{id}', 'MarriageController@removeSponsor');

//Products Routes

$router->get('products', 'ProductsController@index');

$router->post('products', 'ProductsController@store');

$router->put('products/{id}', 'ProductsController@update');

//Product Category Routes

$router->get('product/category','ProductCategoriesController@index');

$router->post('product/category', 'ProductCategoriesController@store');

$router->put('product/category/{id}', 'ProductCategoriesController@update');

//Sales Routes

$router->get('sales', 'SalesController@index');

$router->post('sales', 'SalesController@store');

$router->put('sales/{id}', 'SalesController@update');

//Expense Category Routes

$router->get('expense/category', 'ExpenseCategoriesController@index');

$router->post('expense/category', 'ExpenseCategoriesController@store');

$router->put('expense/category/{id}', 'ExpenseCategoriesController@update');

//Expenses Routes

$router->get('expenses', 'ExpensesController@index');

$router->post('expenses', 'ExpensesController@store');

$router->put('expenses/{id}', 'ExpensesController@update');


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


/**
 * Merchant API
 */

$router->get('merchant','MerchantController@index');
$router->post('merchant','MerchantController@store');
$router->post('merchant/validate','MerchantController@validateForm');
$router->put('merchant/{id}','MerchantController@update');
$router->delete('merchant/{id}','MerchantController@destroy');
$router->get('merchant/{id}','MerchantController@show');

/**
 * Unit API
*/

$router->get('unit','UnitController@index');
$router->post('unit','UnitController@store');
$router->post('unit/validate','UnitController@validateForm');
$router->put('unit/{id}','UnitController@update');
$router->delete('unit/{id}','UnitController@destroy');
$router->get('unit/{id}','UnitController@show');

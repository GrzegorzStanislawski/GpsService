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
    return view('index');
});

$router->get('swagger/schema', 'SwaggerController@schema');

$router->group(['prefix' => 'api', 'middleware' => 'api'], function () use ($router) {
	$router->post('address', 'GpsAddressController@address');
	$router->post('position', 'GpsPositionController@position');
	$router->get('providers', 'GpsController@providers');
});
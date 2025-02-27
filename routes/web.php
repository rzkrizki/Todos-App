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
$router->get('client/{slug}', [
	'as' => 'get-client', 'uses' => 'ClientController@getClient'
]);

$router->post('client', [
	'as' => 'post-client', 'uses' => 'ClientController@postClient'
]);

$router->put('client/{slug}', [
	'as' => 'update-client', 'uses' => 'ClientController@UpdateClient'
]);

$router->delete('client/{slug}', [
	'as' => 'delete-client', 'uses' => 'ClientController@deleteClient'
]);
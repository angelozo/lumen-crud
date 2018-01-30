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

$router->group(['middleware' => 'cors'], function() use ($router) {
	$router->get('/candidate', [
		'as' => 'candidate',
		'uses' => 'CandidateController@index'
	]);

	$router->get('/candidate/{id}', [
		'as' => 'candidate.find',
		'uses' => 'CandidateController@load'
	]);

	$router->post('/candidate', [
		'as' => 'candidate.create',
		'uses' => 'CandidateController@create'
	]);

	$router->delete('/candidate/{id}', [
		'as' => 'candidate.delete',
		'uses' => 'CandidateController@delete'
	]);

	$router->patch('/candidate/{id}', [
		'as' => 'candidate.update',
		'uses' => 'CandidateController@update'
	]);

	$router->put('/candidate/{id}', [
		'as' => 'candidate.update',
		'uses' => 'CandidateController@update'
	]);
});

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('upload', 'Api\ApiArchivesController@upload_file');

Route::group(['prefix' => 'options'], function() {
	Route::post('/', 'Api\ApiOptionsController@store');
	Route::get('/{name}', 'Api\ApiOptionsController@show');
});
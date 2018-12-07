<?php

//Admin routes
Route::group(['prefix' => 'am-admin'], function() {

	//Home routes
	Route::get('/', 'Admin\AdminHomeController@index');
	Route::get('/lost-password', function() {
		return session('access_token');
	});

	//Login & logout
	Route::get('/login', 'Admin\AdminAuthController@login');
	Route::get('/logout', 'Admin\AdminAuthController@logout');

	Route::group(['middleware' => 'admin'], function() {

		Route::get('/dashboard', 'Admin\AdminAccountController@index');
		Route::get('/mi-cuenta', 'Admin\AdminAccountController@MyAccount');

		Route::resources([
		    'libros' => 'Admin\AdminBooksController'
		]);

		//Routes for get info
		Route::prefix('books')->group(function(){
			Route::post('/all', 'Admin\AdminBooksController@getBooks');
			Route::post('/edit/{id}', 'Admin\AdminBooksController@edit');
		});

		//Routes for get info
		Route::prefix('countries')->group(function(){
			Route::get('/all', 'CountriesController@index');
		});
	});
});

Route::get('/', 'Ecommerce\HomeController@index');
Route::get('/iniciar-sesion', 'Ecommerce\HomeController@login');
Route::get('/carrito', 'Ecommerce\HomeController@cart');
Route::get('/especialidad/{slug}', 'Ecommerce\SpecialtiesController@show');
Route::get('/{slug}', 'Ecommerce\BooksController@show');

Auth::routes();
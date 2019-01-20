<?php

//Admin routes
Route::group(['prefix' => 'am-admin'], function() {

	//Home routes
	Route::get('/', 'Admin\AdminHomeController@index');
	Route::get('/lost-password', function() {
		return session('access_token');
	});

	//Login & logout
	Route::get('/login', 'AuthController@login');
	Route::get('/logout', 'AuthController@AdminLogout');

	Route::group(['middleware' => 'admin'], function() {

		Route::get('/dashboard', 'Admin\AdminAccountController@index');
		Route::get('/mi-cuenta', 'Admin\AdminAccountController@MyAccount');

		//Custom routes for "Setting"
		Route::prefix('ajustes')->group(function(){
			Route::get('/', 'Admin\AdminSettingsController@settings');
		});

		//Custom routes for "LIBROS"
		Route::get('libros/inventario', 'Admin\AdminBooksController@inventory');

		Route::resources([
		    'libros' => 'Admin\AdminBooksController',
		    'especialidades' => 'Admin\AdminSpecialtiesController',
		    'autores' => 'Admin\AdminAuthorsController',
		    'sliders' => 'Admin\AdminSlidersController',
		    'usuarios' => 'Admin\AdminUsersController'
		]);

		//Routes for get info "LIBOS"
		Route::prefix('books')->group(function(){
			Route::get('/', 'Admin\AdminBooksController@all');
			Route::post('/edit/{id}', 'Admin\AdminBooksController@edit');
		});

		//Routes for get info "ESPECIALIDADES"
		Route::prefix('specialties')->group(function(){
			Route::get('/', 'Admin\AdminSpecialtiesController@all');
			Route::post('/', 'Admin\AdminSpecialtiesController@store');
			Route::post('/edit/{id}', 'Admin\AdminSpecialtiesController@edit');
		});

		//Routes for get info "AUTORES"
		Route::prefix('authors')->group(function(){
			Route::get('/all', 'Admin\AdminAuthorsController@all');
			Route::post('/edit/{id}', 'Admin\AdminAuthorsController@edit');
		});

		//Routes for get info "SLIDERS"
		Route::prefix('api-sliders')->group(function(){
			Route::get('/all', 'Admin\AdminSlidersController@all');
			Route::post('/edit/{id}', 'Admin\AdminSlidersController@edit');
		});

		//Routes for get info "USERS"
		Route::prefix('users')->group(function(){
			Route::post('/all', 'Admin\AdminUsersController@all');
			Route::post('/edit/{id}', 'Admin\AdminUsersController@edit');
		});

		//Routes for get info "PAISES"
		Route::prefix('countries')->group(function(){
			Route::get('/all', 'CountriesController@index');
		});
	});
});

//Authentication ecommerce routes
Route::get('/iniciar-sesion', 'Ecommerce\HomeController@login');
Route::get('/logout', 'AuthController@EcommerceLogout');

Route::group(['middleware' => 'ecommerce', 'prefix' => 'mi-cuenta'], function() {
	Route::get('/', 'Ecommerce\AccountController@account');
});

//Rutas simples
Route::get('/', 'Ecommerce\HomeController@index');
Route::get('/carrito', 'Ecommerce\HomeController@cart');
Route::get('/finalizar-compra', 'Ecommerce\HomeController@checkout');
Route::get('/contacto', 'Ecommerce\HomeController@contact');

//Especialidades
Route::get('/especialidad/{slug}', 'Ecommerce\SpecialtiesController@show');
Route::get('/especialidad', function() { return redirect('/especialidades'); });
Route::get('/especialidades', 'Ecommerce\SpecialtiesController@index');

//Autores
Route::get('/autores', 'Ecommerce\AuthorsController@index');
Route::get('/autor', function() { return redirect('/autores'); });
Route::get('/autor/{slug}', 'Ecommerce\AuthorsController@show');

Route::get('/blog', 'Ecommerce\PostsController@index');
Route::get('/{slug}', 'Ecommerce\PostsController@show');

Auth::routes();

//Carts
Route::group(['prefix' => 'carts'], function() {
	Route::post('/', 'Ecommerce\CartsController@store');
	Route::put('/', 'Ecommerce\CartsController@update');
	Route::get('/{id}', 'Ecommerce\CartsController@show');
});
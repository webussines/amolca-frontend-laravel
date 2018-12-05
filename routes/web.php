<?php

//Admin routes
Route::prefix('am-admin')->group(function() {
	Route::get('/', 'Admin\AdminHomeController@index');
	Route::get('/lost-password', function() {
		return 'Contraseña perdida';
	});

	Route::get('/dashboard', 'Admin\AdminAccountController@index');
	Route::get('/mi-cuenta', 'Admin\AdminAccountController@MyAccount');

	Route::resources([
	    'libros' => 'Admin\AdminBooksController'
	]);

	//Routes for get info
	Route::prefix('books')->group(function(){
		Route::post('/get-books', 'Admin\AdminBooksController@getBooks');
	});
});

Route::get('/', 'Ecommerce\HomeController@index');
Route::get('/iniciar-sesion', 'Ecommerce\HomeController@login');
Route::get('/carrito', 'Ecommerce\HomeController@cart');
Route::get('/especialidad/{slug}', 'Ecommerce\SpecialtiesController@show');
Route::get('/{slug}', 'Ecommerce\BooksController@show');

Auth::routes();
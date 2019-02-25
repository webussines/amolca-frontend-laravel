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
	Route::post('/register', 'AuthController@register');
	Route::get('/logout', 'AuthController@AdminLogout');

	Route::group(['middleware' => 'admin'], function() {

		Route::get('/dashboard', 'Admin\AdminAccountController@index');
		Route::get('/mi-cuenta', 'Admin\AdminAccountController@MyAccount');

		//Custom routes for "Setting"
		Route::prefix('ajustes')->group(function(){
			Route::get('/', 'Admin\AdminSettingsController@settings');
			Route::get('/tienda', 'Admin\AdminSettingsController@shop');
		});

		//Custom routes for "LIBROS"
		Route::get('libros/inventario', 'Admin\AdminBooksController@inventory');

		//Custom routes for "Usuarios"
		Route::get('clientes', 'Admin\AdminUsersController@clients');

		Route::resources([
		    'libros' => 'Admin\AdminBooksController',
		    'especialidades' => 'Admin\AdminSpecialtiesController',
		    'autores' => 'Admin\AdminAuthorsController',
		    'sliders' => 'Admin\AdminSlidersController',
		    'usuarios' => 'Admin\AdminUsersController',
		    'blog' => 'Admin\AdminBlogsController',
		    'eventos' => 'Admin\AdminEventsController',
		    'pedidos' => 'Admin\AdminOrdersController',
		    'formularios' => 'Admin\AdminFormsController',
		    'lotes' => 'Admin\AdminLotsController',
		    'cupones' => 'Admin\AdminCouponsController',
		]);

		Route::get('carritos', 'Admin\AdminOrdersController@carts');
		Route::get('carritos/{id}', 'Admin\AdminOrdersController@show');

		//Routes for get info "LIBOS"
		Route::prefix('books')->group(function(){
			Route::get('/', 'Admin\AdminBooksController@all');
			Route::post('/edit/{id}', 'Admin\AdminBooksController@edit');
			Route::post('/inventory', 'Admin\AdminBooksController@update_inventory');
		});

		//Routes for get info "BLOGS"
		Route::prefix('blogs')->group(function(){
			Route::get('/', 'Admin\AdminBlogsController@all');
			Route::post('/edit/{id}', 'Admin\AdminBlogsController@edit');
		});

		//Routes for get info "EVENTOS"
		Route::prefix('events')->group(function(){
			Route::get('/', 'Admin\AdminEventsController@all');
			Route::post('/edit/{id}', 'Admin\AdminEventsController@edit');
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
			Route::get('/all', 'Admin\AdminUsersController@all');
			Route::get('/clients', 'Admin\AdminUsersController@getclients');
			Route::post('/edit/{id}', 'Admin\AdminUsersController@edit');
		});

		//Routes for get info "PEDIDOS"
		Route::prefix('orders')->group(function(){
			Route::get('/', 'Admin\AdminOrdersController@all');
			Route::get('/carts', 'Admin\AdminOrdersController@all_carts');
			Route::post('/edit/{id}', 'Admin\AdminOrdersController@edit');
			Route::post('/{id}/states/store', 'Admin\AdminOrdersController@store_state');
		});

		//Routes for get info "FORMULARIOS"
		Route::prefix('forms')->group(function(){
			Route::get('/', 'Admin\AdminFormsController@all');
		});

		//Routes for get info "LOTES"
		Route::prefix('lots')->group(function(){
			Route::get('/', 'Admin\AdminLotsController@all');
			Route::post('/edit/{id}', 'Admin\AdminLotsController@edit');
		});

		//Routes for get info "LOTES"
		Route::prefix('coupons')->group(function(){
			Route::get('/', 'Admin\AdminCouponsController@all');
			Route::post('/edit/{id}', 'Admin\AdminCouponsController@edit');
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
	Route::get('/pedidos', 'Ecommerce\AccountController@orders');
	Route::get('/direccion', 'Ecommerce\AccountController@direction');
	Route::get('/informacion', 'Ecommerce\AccountController@information');
});

//Rutas simples
Route::get('/', 'Ecommerce\HomeController@index');
Route::get('/carrito', 'Ecommerce\CartsController@index');
Route::get('/contacto', 'Ecommerce\HomeController@contact');
Route::get('/terminos-y-condiciones', 'Ecommerce\HomeController@termsandconditions');

Route::get('/finalizar-compra', 'Ecommerce\CheckoutController@checkout');
Route::post('/checkout/response', 'Ecommerce\CheckoutController@PaymentResponse');
Route::get('/checkout/respuesta', 'Ecommerce\CheckoutController@PaymentResponseView');

//Novedades
Route::get('/novedades/{slug}', 'Ecommerce\BooksController@news');

//Especialidades
Route::get('/especialidad/{slug}', 'Ecommerce\SpecialtiesController@show');
Route::get('/especialidad', function() { return redirect('/especialidades'); });
Route::get('/especialidades', 'Ecommerce\SpecialtiesController@index');

//Eventos
Route::get('/evento/{slug}', 'Ecommerce\EventsController@show');
Route::get('/evento', function() { return redirect('/eventos'); });
Route::get('/eventos', 'Ecommerce\EventsController@index');

//Autores
Route::get('/autores', 'Ecommerce\AuthorsController@index');
Route::get('/autor', function() { return redirect('/autores'); });
Route::get('/autor/{slug}', 'Ecommerce\AuthorsController@show');

Route::get('/blog', 'Ecommerce\PostsController@index');
Route::get('/buscar', 'Ecommerce\PostsController@searcher');
Route::get('/{slug}', 'Ecommerce\PostsController@show');

Auth::routes();

//Carts
Route::group(['prefix' => 'carts'], function() {
	Route::post('/', 'Ecommerce\CartsController@store');
	Route::post('/checkout', 'Ecommerce\CartsController@create_order');
	Route::put('/', 'Ecommerce\CartsController@update');
	Route::get('/{id}', 'Ecommerce\CartsController@show');
	Route::get('/{id}', 'Ecommerce\CartsController@get_orders');

	Route::post('/amount', 'Ecommerce\CartsController@change_amount');
	Route::get('/coupons/{code}', 'Ecommerce\CartsController@validate_coupon');
});

//Books
Route::group(['prefix' => 'books'], function() {
	Route::get('/{id}', 'Ecommerce\PostsController@post_info');
});
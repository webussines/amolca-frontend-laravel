<?php

Route::get('/', 'HomeController@index');
Route::get('/iniciar-sesion', 'HomeController@login');
Route::get('/carrito', 'HomeController@cart');
Route::get('/especialidad/{slug}', 'SpecialtiesController@show');
Route::get('/{slug}', 'BooksController@show');

Auth::routes();
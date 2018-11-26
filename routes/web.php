<?php

Route::get('/', 'HomeController@index');
Route::get('/iniciar-sesion', 'HomeController@login');
Route::get('/carrito', 'HomeController@cart');

Auth::routes();
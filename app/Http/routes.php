<?php
Route::resource('trainings', 'TrainingsController');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/trainings', 'AdminController@trainings');
Route::get('/admin/trainings/{id}/edit', 'AdminController@edit');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

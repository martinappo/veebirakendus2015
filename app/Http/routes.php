<?php
Route::get('foo', 'FooController@index');
Route::resource('trainings', 'TrainingsController');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

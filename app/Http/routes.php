<?php
Route::get('foo', 'FooController@index');
Route::resource('trainings', 'TrainingsController');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

Route::post('/authenticate', 'Auth\AuthController@authenticate');
Route::get('auth/social/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/socialcallback/{provider}', 'Auth\AuthController@handleProviderCallback');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

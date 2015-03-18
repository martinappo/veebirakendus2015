<?php
Route::resource('trainings', 'TrainingsController');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

Route::post('/authenticate', 'Auth\AuthController@authenticate');
Route::get('auth/social/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/socialcallback/{provider}', 'Auth\AuthController@handleProviderCallback');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/trainings', 'AdminController@trainings');
Route::get('/admin/trainings/{id}/edit', 'AdminController@editTraining');
Route::get('/admin/users','AdminController@users');
Route::get('/admin/users/{id}/edit','AdminController@editUser');
Route::patch('/admin/users/{id}','AdminController@updateUser');
Route::delete('/admin/users/{id}','AdminController@destroyUser');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

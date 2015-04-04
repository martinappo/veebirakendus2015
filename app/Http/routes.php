<?php
/*
Trainings routes
 */
Route::resource('trainings', 'TrainingsController');
Route::put('trainings/{id}/upload', 'TrainingsController@upload');
Route::delete('trainings/file/{id}', 'TrainingsController@destroyTrainingFile');
Route::get('trainingsmap', 'TrainingsController@trainingsForMap');

/*
Home routes
 */
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

/*
Authentication routes
 */
Route::post('/authenticate', 'Auth\AuthController@authenticate');
Route::get('auth/social/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/socialcallback/{provider}', 'Auth\AuthController@handleProviderCallback');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*
Admin routes
 */
//Admin panel
Route::get('/admin', 'AdminController@index');
//Actions with trainings
Route::get('/admin/trainings', 'AdminController@trainings');
Route::post('/admin/trainings/bulkedit', 'AdminController@trainingsBulkEdit');
//Actions with users
Route::get('/admin/users','AdminController@users');
Route::get('/admin/users/{id}/edit','AdminController@editUser');
Route::patch('/admin/users/{id}','AdminController@updateUser');
Route::delete('/admin/users/{id}','AdminController@destroyUser');
//Actions with tags
Route::delete('/admin/tags/{id}','AdminController@destroyTag');


/*
User routes
 */
Route::get('/profile', 'UserController@index');
Route::delete('/profile','UserController@destroyUser');

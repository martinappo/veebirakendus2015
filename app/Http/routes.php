<?php
/*
Trainings routes
 */
Route::get('trainings/map', 'TrainingsController@trainingsForMap');
Route::get('trainings/search', 'TrainingsController@search');
Route::resource('trainings', 'TrainingsController');
Route::put('trainings/{id}/upload', 'TrainingsController@upload');
Route::delete('trainings/file/{id}', 'TrainingsController@destroyTrainingFile');

/*
Comments routes
 */
Route::resource('comments', 'CommentsController');

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
Route::delete('auth/social/{provider}', 'Auth\AuthController@disconnect');
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
Route::get('/admin/trainings/sort','AdminController@sortTrainings');
Route::post('/admin/trainings/bulkedit', 'AdminController@trainingsBulkEdit');
//Actions with users
Route::get('/admin/users','AdminController@users');
Route::get('/admin/users/sort','AdminController@sortUsers');
Route::get('/admin/users/{id}/edit','AdminController@editUser');
Route::patch('/admin/users/{id}','AdminController@updateUser');
Route::delete('/admin/users/{id}','AdminController@destroyUser');
Route::post('/admin/users/bulkedit', 'AdminController@usersBulkEdit');
//Actions with tags
Route::delete('/admin/tags/{id}','AdminController@destroyTag');


/*
User routes
 */
Route::get('/profile', 'UserController@index');
Route::delete('/profile','UserController@destroyUser');
Route::get('/notifications', 'UserController@notifications');
Route::delete('/notification/{id}', 'UserController@destroyNotification');
Route::post('/rate/{id}', 'UserController@rateTraining');
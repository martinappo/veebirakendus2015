<?php namespace App\Http\Controllers;

use App\User;
use App\Training;
use App\Http\Requests;
use Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin');
	}

	/**
	 * Show the application dashboard to admin.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::latest()->take(3)->get();
		$trainings = Training::latest()->notConfirmed()->get();
		return view('admin.home', compact('users', 'trainings'));
	}

	/**
	 * Show the trainings view to admin.
	 * 
	 * @return Response
	 */
	public function trainings()
	{
		$trainings = Training::latest()->get();
		return view('admin.trainings', compact('trainings'));
	}

	/**
	 * Show edit training view to admin.
	 * 
	 * @param  int $id [id of training]
	 * @return Response
	 */
	public function editTraining($id)
	{
		$training = Training::findOrFail($id);
		return view('admin.training', compact('training'));
	}

	/**
	 * Show users list to admin.
	 * @return Response
	 */
	public function users()
	{
		$users = User::latest()->get();
		return view('admin.users', compact('users'));
	}

	/**
	 * Show single user edit page to admin.
	 * @param  int $id [Id of the user]
	 * @return Response
	 */
	public function editUser($id)
	{
		$user = User::findOrFail($id);
		return view('admin.user', compact('user'));
	}

	/**
	 * Update the user
	 * Admin can change only user role
	 * @param  int $id [Id of the user]
	 * @return Response
	 */
	public function updateUser($id)
	{
		$user = User::findOrFail($id);
		$user->update(Request::all());
		return view('admin.user', compact('user'));
	}
}

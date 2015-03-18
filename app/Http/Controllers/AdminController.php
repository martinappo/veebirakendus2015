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
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::latest()->take(3)->get();
		$trainings = Training::latest()->notConfirmed()->get();
		return view('admin.home', compact('users', 'trainings'));
	}

	public function trainings()
	{
		$trainings = Training::latest()->get();
		return view('admin.trainings', compact('trainings'));
	}

	public  function editTraining($id)
	{
		$training = Training::findOrFail($id);
		return view('admin.training', compact('training'));
	}

	public  function users()
	{
		$users = User::latest()->get();
		return view('admin.users', compact('users'));
	}

	public  function editUser($id)
	{
		$user = User::findOrFail($id);
		return view('admin.user', compact('user'));
	}

	public  function updateUser($id)
	{
		$user = User::findOrFail($id);
		$user->update(Request::all());
		return view('admin.user', compact('user'));
	}
}

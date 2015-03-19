<?php namespace App\Http\Controllers;

use Auth;

class UserController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the user profile.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		return view('user.home', compact('user'));
	}

	/**
	 * Delete the user from database
	 * @param  int $id [Id of the user]
	 * @return Response
	 */
	public function destroyUser()
	{
		$user = Auth::user();
		Auth::logout();
		$user->delete();
		session()->flash('flash_message', 'Kasutaja kustutatud!');
		return redirect('home');
	}

}

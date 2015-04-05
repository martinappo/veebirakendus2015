<?php namespace App\Http\Controllers;

use App\Notification;
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
		$trainings = $user->trainings()->get();
		return view('user.home', compact('user', 'trainings'));
	}

	/**
	 * Delete the user from database
	 * @param
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

	/**
	 * Get users notifications
	 * @param 
	 * @return Response
	 */
	public function notifications()
	{
		return view('partials.notifications');
	}

}

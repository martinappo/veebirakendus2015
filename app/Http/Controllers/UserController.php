<?php namespace App\Http\Controllers;

use App\Notification;
use Auth;
use App\Rating;
use App\Training;
use App\Http\Requests;
use Request;

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

	//Users notifications =================================================

	/**
	 * Get users notifications
	 * @param 
	 * @return Response
	 */
	public function notifications()
	{
		$notifications = Auth::user()->notifications()->latest()->get();
		return view('partials.notifications', compact('notifications'));
	}

	/**
	 * Delete a notification
	 * @param 
	 * @return Response
	 */
	public function destroyNotification($id)
	{
		Notification::destroy($id);
		return response()->json('success', 200);
	}

	//User->trainings ratings ==============================================

	/**
	 * Add a rating to a training
	 * @param  [int] $id [training id]
	 * @return Response
	 */
	public function rateTraining($id)
	{
		$rating = Rating::firstOrNew(['training_id' => $id, 'user_id' => Auth::user()->id]);
		$rating->value = Request::input('value');
		$rating->training_id = $id;
		Auth::user()->ratings()->save($rating);

		$training = Training::findOrFail($id);

		return view('partials.trainings-rate', compact('training'));
	}

}

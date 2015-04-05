<?php namespace App\Http\Controllers;

use App\User;
use App\Training;
use App\Notification;
use App\Tag;
use App\Http\Requests;
use App\Http\Requests\TrainingRequest;
use Request;
use App\Http\Controllers\Controller;
use DB;

class AdminController extends Controller {

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
		$trainings = $this->getTrainingsWithUsers();
		$tags = Tag::latest()->get();
		return view('admin.trainings', compact('trainings', 'tags'));
	}

	/**
	 * Edit trainings by bulk in trainings list.
	 * 
	 * @return Response
	 */
	public function trainingsBulkEdit()
	{
		$selectedTrainings = array();

		foreach (Request::all() as $key => $item)
		{
			if (strcmp($item, 'selected') == 0)
			{
				array_push($selectedTrainings, $key);
			}
		}

		switch (Request::input('action'))
		{
			case 'delete':
				Training::destroy($selectedTrainings);
				session()->flash('flash_message', 'Treening(ud) kustutatud!');
				break;
			case 'confirm':
				foreach ($selectedTrainings as $training)
				{
					$training = Training::find($training);
					$training->update(array('confirmed' => true));
					$this->addNotification($training);
				}
				session()->flash('flash_message', 'Treening(ud) kinnitatud!');
				break;
			case 'removeConfirmation':
				foreach ($selectedTrainings as $training)
				{
					$training = Training::find($training);
					$training->update(array('confirmed' => true));
					$this->addNotification($training);
				}
				session()->flash('flash_message', 'Kinnitus eemaldatud!');
				break;
		}

		return redirect('admin/trainings');
	}

	/**
	 * Show users list to admin.
	 * @return Response
	 */
	public function users()
	{
		//$users = User::latest()->get();
		$users = $this->getUsersWithNrOfTrainigs();
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
		$user->role = Request::input('role');
		$user->update();
		session()->flash('flash_message', 'Kasutaja andmed uuendatud!');
		return redirect('admin/users');
	}

	/**
	 * Delete the user from database
	 * @param  int $id [Id of the user]
	 * @return Response
	 */
	public function destroyUser($id)
	{
		$user = User::findOrFail($id);
		$user->delete();
		session()->flash('flash_message', 'Kasutaja kustutatud!');
		return redirect('admin/users');
	}

	/**
	 * Delete the tag from database
	 * @param  int $id [Id of the tag]
	 * @return Response
	 */
	public function destroyTag($id)
	{
		$tag = Tag::findOrFail($id);
		$tag->delete();
		session()->flash('flash_message', 'Märksõna kustutatud!');
		return redirect('admin/trainings');
	}

	/* ======================================== Private functions =================================== */

	/**
	 * Calculates the number of trainings the user have create
	 * @return array [Array of users with number of trainings]
	 */
	private function getUsersWithNrOfTrainigs() {
		$usersWithTrainings = array();
		$usersWithTrainings = DB::select(
			'SELECT
				users.id,
				users.name,
				users.email,
				users.fb_id,
				users.g_id,
				users.role,
				COUNT(trainings.id) as training_count
			FROM trainings
			RIGHT JOIN users
			ON trainings.user_id=users.id
			GROUP BY id
		');

		return $usersWithTrainings;
	}

	/**
	 * Joins user trainings table with user
	 * @return array [Trainings with users]
	 */
	private function getTrainingsWithUsers() {
		$trainingsWithUser = array();
		$trainingsWithUser = DB::select(
			'SELECT 
				trainings.id as id, 
				trainings.title,
				trainings.confirmed,
				trainings.description,
				trainings.aadress,
				users.id as owner_id, 
				users.name as owner
			FROM users
			INNER JOIN trainings
			ON users.id=trainings.user_id
		');

		return $trainingsWithUser;
	}

	/**
	 * Adds notification about the training.
	 * @param $training
	 */
	private function addNotification($training)
	{
		$owner = $training->user()->first();
		$notification = new Notification();
		$notification->title = 'Treeningut muudetud!';
		$notification->content = 'Administraator muutis teie treeningut: '. $training->title . '.';
		$owner->notifications()->save($notification);
	}

}
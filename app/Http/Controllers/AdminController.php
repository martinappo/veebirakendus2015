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
		$userCount = User::all()->count();
		$users = User::latest()->take(3)->get();
		$trainingCount = Training::all()->count();
		$trainings = Training::latest()->notConfirmed()->get();
		return view('admin.home', compact('users', 'trainings', 'userCount', 'trainingCount'));
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
				foreach ($selectedTrainings as $training)
				{
					$training = Training::find($training);
					$message = 'Administraator kustutas teie lisatud treeningu: '. $training->title . '.';
					$training->delete();
					$this->addNotification($training, $message);
				}
				session()->flash('flash_message', 'Treening(ud) kustutatud!');
				break;
			case 'confirm':
				foreach ($selectedTrainings as $training)
				{
					$training = Training::find($training);
					if (!$training->confirmed)
					{
						$training->update(array('confirmed' => true));
						$message = 'Administraator kinnitas teie treeningu: '. $training->title . '.';
						$this->addNotification($training, $message);
					}
				}
				session()->flash('flash_message', 'Treening(ud) kinnitatud!');
				break;
			case 'removeConfirmation':
				foreach ($selectedTrainings as $training)
				{
					$training = Training::find($training);
					if ($training->confirmed)
					{
						$training->update(array('confirmed' => false));
						$message = 'Administraator eemaldas teie treeningult kinnituse: '. $training->title . '.';
						$this->addNotification($training, $message);
					}
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
		$users = $this->getUsersWithInfo('users.id','DESC');
		return view('admin.users', compact('users'));
	}

	/**
	 * Sort users by attribute.
	 * @return Response
	 */
	public function sortUsers()
	{
		$users = array();
		switch (Request::input('id'))
		{
			case 'sort-name':
				if (strcmp(Request::input('dir'), 'up') == 0)
				{
					$users = $this->getUsersWithInfo('users.name','ASC');
				}
				else
				{
					$users = $this->getUsersWithInfo('users.name','DESC');
				}
				break;
		}

		return view('partials.users-list', compact('users'));
	}

		/**
	 * Edit users by bulk in trainings list.
	 * 
	 * @return Response
	 */
	public function usersBulkEdit()
	{
		$selectedUsers = array();

		foreach (Request::all() as $key => $item)
		{
			if (strcmp($item, 'selected') == 0)
			{
				array_push($selectedUsers, $key);
			}
		}

		switch (Request::input('action'))
		{
			case 'delete':
				User::destroy($selectedUsers);
				session()->flash('flash_message', 'Kasutaja(d) kustutatud!');
				break;
			case 'block':
				User::whereIn('id', $selectedUsers)->update(array('blocked' => true));
				session()->flash('flash_message', 'Blokeering(ud) lisatud!');
				break;
			case 'unBlock':
				User::whereIn('id', $selectedUsers)->update(array('blocked' => false));
				session()->flash('flash_message', 'Blokeering(ud) eemaldatud!');
				break;
		}

		return redirect('admin/users');
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
		$user->blocked = Request::input('blocked_until');
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
	private function getUsersWithInfo($sortBy, $direction) {
		$usersWithTrainings = array();
		$usersWithTrainings = DB::select(
			'SELECT
				users.id,
				users.name,
				users.email,
				users.fb_id,
				users.g_id,
				users.role,
				users.blocked,
				users.blocked_until,
				(SELECT COUNT(*) FROM notifications WHERE users.id = notifications.user_id) as notifications_count,
				(SELECT COUNT(*) FROM trainings WHERE users.id = trainings.user_id) as training_count
			FROM users ORDER BY '.$sortBy.' '.$direction
		);

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
	 * @param string $training [which training is edited]
	 * @param string $message [what is the message of notification]
	 */
	private function addNotification($training, $message)
	{
		$owner = $training->user()->first();
		$notification = new Notification();
		$notification->title = 'Treeningut muudetud!';
		$notification->content = $message;
		$owner->notifications()->save($notification);
	}

}
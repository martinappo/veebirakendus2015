<?php namespace App\Http\Controllers;

use App\User;
use App\Training;
use App\Http\Repositories\NotificationsRepository;
use App\Tag;
use App\Http\Requests;
use App\Http\Requests\TrainingRequest;
use Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class AdminController extends Controller {

	/**
	 * The repository of notifications. We can add and remove notifications
	 * through this.
	 * @var [NotificationsRepository]
	 */
	protected $notificationsRepo;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(NotificationsRepository $notificationsRepo)
	{
		$this->notificationsRepo = $notificationsRepo;
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
		$notifications = Auth::user()->notifications()->latest()->get();
		return view('admin.home', compact('users', 'trainings', 'userCount', 'trainingCount', 'notifications'));
	}

	/**
	 * Show the trainings view to admin.
	 * 
	 * @return Response
	 */
	public function trainings()
	{
		$trainings = $this->getTrainingsWithUsers('id','DESC');
		$tags = Tag::latest()->get();
		return view('admin.trainings', compact('trainings', 'tags'));
	}

	/**
	 * Sort trainings by attribute.
	 * @return Response
	 */
	public function sortTrainings()
	{
		$trainings = array();
			$trainings = $this->getTrainingsWithUsers(Request::input('id'), Request::input('dir'));
		return view('partials.admin-trainings-list', compact('trainings'));
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
					if (!$training->user()->first()->isAdmin())
					{
						$this->notificationsRepo->create($training->user()->first(), 'Treening kustutatud', $message);
					}
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
						if (!$training->user()->first()->isAdmin())
						{
							$message = 'Administraator kinnitas teie treeningu: '. $training->title . '.';
							$this->notificationsRepo->create($training->user()->first(), 'Treening kinnitatud', $message);
						}
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
						if (!$training->user->first()->isAdmin())
						{
							$message = 'Administraator eemaldas teie treeningult kinnituse: '. $training->title . '.';
							$this->notificationsRepo->create($training->user()->first(), 'Treeningut muudetud', $message);
						}
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
		$users = $this->getUsersWithInfo(Request::input('id'), Request::input('dir'));
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
		$user->blocked = Request::input('blocked');
		$user->blocked_until = Request::input('blocked_until');
		$user->block_reason = Request::input('block_reason');
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
				users.block_reason,
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
	private function getTrainingsWithUsers($sortBy, $direction) {
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
			ORDER BY '.$sortBy.' '.$direction
		);

		return $trainingsWithUser;
	}

}
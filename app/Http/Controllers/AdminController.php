<?php namespace App\Http\Controllers;

use App\User;
use App\Training;
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
		dd(Request::input('selected'));
	}

	/**
	 * Show edit training view to admin.
	 * 
	 * @param  int $id [id of training]
	 * @return Response
	 */
	public function editTraining($id)
	{
		$tags = Tag::lists('name', 'id');

		$training = Training::findOrFail($id);
		return view('admin.training', compact('training', 'tags'));
	}

	/**
	 * Update edited training for admin,
	 * set flash message and
	 * redirect to trainings
	 * 
	 * @param  int
	 * @param  TrainingRequest
	 * @return Response
	 */
	public function updateTraining($id, TrainingRequest $request)
	{
		$training = Training::findOrFail($id);
		$training->update($request->all());

		$tags = array();

		if ($request->input('tag_list'))
		{
			$tags = $request->input('tag_list');
		}

		$this->syncTags($training, $tags);

		session()->flash('flash_message', 'Treening uuendatud!');

		return redirect('admin/trainings');
	}

	/**
	 * Delete the training
	 * 
	 * @param  int
	 * @return Response
	 */
	public function destroyTraining($id)
	{
		$training = Training::findOrFail($id);
		$training->delete();

		session()->flash('flash_message', 'Treening kustutatud!');

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
	 * Determine if user has inserted a new tag
	 * Sync up tags in database
	 * 
	 * @param  Training 
	 * @param  array tags
	 * @return void
	 */
	private function syncTags(Training $training, array $tags) 	{
		/*
			If tag hasn't got a numerical value then it must be just added by user.
			If the value is numerical then check if it's an id of a tag
			Then we save it to database and sync it with id.
		 */
		foreach ($tags as $key => $tag){
			if ( ! is_numeric($tag)) {
				$tagId = $this->createTag($tag);
				$tags[$key] = (string)$tagId;
			}
			elseif ( ! Tag::find($tag)) {
				$tagId = $this->createTag($tag);
				$tags[$key] = (string)$tagId;
			}
		}

		$training->tags()->sync($tags);
		return;
	}

	/**
	 * Save a new tag to database
	 * Returns the id of added tag
	 * 
	 * @param  String
	 * @return int
	 */
	private function createTag($tagName)
	{
		$created_at = date('Y-m-d H:i:s');
		DB::statement('
				INSERT INTO tags (name, created_at, updated_at) 
				VALUES ("'.$tagName.'", "'.$created_at.'", "'.$created_at.'");
			');
		$id = DB::select('
				SELECT DISTINCT id 
				FROM tags 
				WHERE name = "'.$tagName.'"
			')[0]->id;

		return $id;
	}
}
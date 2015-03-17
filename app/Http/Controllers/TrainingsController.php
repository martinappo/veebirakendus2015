<?php namespace App\Http\Controllers;

use App\Training;
use App\Tag;
use App\Http\Requests;
use App\Http\Requests\TrainingRequest;
use App\Http\Controllers\Controller;
use Auth;
use DB;

use Request;

class TrainingsController extends Controller {

	/**
	 * Create a new trainings controller
	 */
	public function __construct() {

		$this->middleware('auth', ['except' => 'index']);
		$this->middleware('trainingOwner', ['only' => array('edit','update')]);
	}

	/**
	 * Trainings main page
	 * 
	 * @return Response
	 */
	public function index() {

		$trainings = Training::latest()->confirmed()->get();
		return view('trainings.index', compact('trainings'));
	}

	/**
	 * Create training page
	 * 
	 * @return Response
	 */
	public function create() {
		$tags = Tag::lists('name', 'id');

		return view('trainings.create', compact('tags'));
	}

	/**
	 * Store trainings to database 
	 * and redirect to trainings
	 * 
	 * @param  TrainingRequest
	 * @return Response
	 */
	public function store(TrainingRequest $request) {

		$this->createTraining($request);

		session()->flash('flash_message', 'Treening lisatud!');

		return redirect('trainings');
	}

	/**
	 * Show edit trainings page
	 * 
	 * @param  int
	 * @return Response
	 */
	public function edit($id) {

		$tags = Tag::lists('name', 'id');

		$training = Training::findOrFail($id);
		return view('trainings.edit', compact('training', 'tags'));
	}

	/**
	 * Update edited training,
	 * set flash message and
	 * redirect to trainings
	 * 
	 * @param  int
	 * @param  TrainingRequest
	 * @return Response
	 */
	public function update($id, TrainingRequest $request) {

		$training = Training::findOrFail($id);
		$training->confirmed = false;
		$training->update($request->all());

		$this->syncTags($training, $request->input('tag_list'));

		session()->flash('flash_message', 'Treening uuendatud!');

		return redirect('trainings');
	}

	/*
	================================================== Private functions start from here ====================================================
	 */

	/**
	 * Determine if user has inserted a new tag
	 * Sync up tags in database
	 * 
	 * @param  Training 
	 * @param  array tags
	 * @return void
	 */
	private function syncTags(Training $training, array $tags) {

		/*
			If tag hasnt got a numerical value then it must be just added by user.
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
	 * Save training to database
	 * 
	 * @param  TrainingRequest $request
	 * @return Training
	 */
	private function createTraining(TrainingRequest $request) {

		$training = new Training($request->all());
		Auth::user()->trainings()->save($training);

		$this->syncTags($training, $request->input('tag_list'));

		return $training;
	}

	/**
	 * Save a new tag to database
	 * Returns the id of added tag
	 * 
	 * @param  String
	 * @return int
	 */
	private function createTag($tagName) {

		$created_at = date('Y-m-d H:i:s');
		DB::statement('INSERT INTO tags (name, created_at, updated_at) VALUES ("'.$tagName.'", "'.$created_at.'", "'.$created_at.'");');
		$id = DB::select('SELECT DISTINCT id FROM tags WHERE name = "'.$tagName.'"')[0]->id;

		return $id;
	}

}
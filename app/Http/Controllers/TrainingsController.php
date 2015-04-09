<?php namespace App\Http\Controllers;

use App\Training;
use App\User;
use App\Http\Repositories\NotificationsRepository;
use App\Tag;
use App\TrainingFile;
use App\Http\Requests;
use App\Http\Requests\TrainingRequest;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use File;
use DateTime;
use Image;
use Request;
use Response;

class TrainingsController extends Controller {

	/**
	 * The repository of notifications. We can add and remove notifications
	 * through this.
	 * @var [NotificationsRepository]
	 */
	protected $notificationsRepo;

	/**
	 * Create a new trainings controller
	 */
	public function __construct(NotificationsRepository $notificationsRepo)
	{
		$this->notificationsRepo = $notificationsRepo;
		$this->middleware('auth', ['except' => array('index', 'trainingsForMap', 'search') ]);
		$this->middleware('trainingOwner', ['only' => array('edit','update') ]);
	}

	/**
	 * Trainings main page
	 * 
	 * @return Response
	 */
	public function index()
	{
		$trainings = Training::latest()->confirmed()->get();
		$tags = Tag::lists('name', 'id');

		return view('trainings.index', compact('trainings','tags'));
	}

	/**
	 * Create training page
	 * 
	 * @return Response
	 */
	public function create()
	{
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
	public function store(TrainingRequest $request)
	{
		$training = $this->createTraining($request);

		session()->flash('flash_message', 'Treening lisatud! Nüüd võid lisada oma treeningule ka pilte.');

		$tags = Tag::lists('name', 'id');

		if (!Auth::user()->isAdmin())
		{
			$message = 'Kasutaja ' . Auth::user()->name . ' lisas uue treeningu, mis tuleb üle vaadata: ' . $training->title;
			$this->notificationsRepo->createMany(User::where('role', 'admin')->get(), 'Uus treening lisatud!', $message);
		}

		return view('trainings.edit', compact('training', 'tags'));
	}

	/**
	 * Show edit trainings page
	 * 
	 * @param  int
	 * @return Response
	 */
	public function edit($id)
	{
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
	public function update($id, TrainingRequest $request)
	{
		$training = Training::findOrFail($id);
		$oldStatus = $training->confirmed;

		$isAdmin = Auth::user()->isAdmin();
		if (!$isAdmin)
		{
			$training->confirmed = false;
			$message = 'Kasutaja ' . Auth::user()->name . ' muutis treeningut, mis tuleb üle vaadata: ' . $training->title;
			$this->notificationsRepo->createMany(User::where('role', 'admin')->get(), 'Treeningut muudetud!', $message);
		}

		$training->update($request->all());

		$tags = array();

		if ($request->input('tag_list'))
		{
			$tags = $request->input('tag_list');
		}

		$this->syncTags($training, $tags);

		session()->flash('flash_message', 'Treening uuendatud!');

		if ($isAdmin)
		{
			$this->addNotifications($oldStatus, $training);
			return redirect('admin/trainings');
		}

		return redirect('profile');
	}

	/**
	 * Delete the training
	 * 
	 * @param  int
	 * @return Response
	 */
	public function destroy($id)
	{
		$training = Training::findOrFail($id);
		$training->delete();

		session()->flash('flash_message', 'Treening kustutatud!');

		return redirect('profile');
	}

	/**
	 * Get trainings for google maps api
	 * 
	 * @return Response
	 */
	public function trainingsForMap()
	{
		return Training::latest()->confirmed()->get();
	}

	/**
	 * Attach an uploaded file to the training
	 * 
	 * @param  int
	 * @return Response
	 */
	public function upload($id)
	{
		$fileObject = Request::file('file');
		$fileRealName = $fileObject->getClientOriginalName();
		$error = $this->verifyImageFile($fileObject);

		if (empty($error))
		{
			$destinationPath = 'uploads/training' . $id . '/';

			if (!File::isDirectory($destinationPath))
			{
				File::makeDirectory($destinationPath);
			}

			$date = new DateTime();
			$filename = $date->getTimestamp() . '_' . $fileRealName;

			$uploadSuccess = $fileObject->move($destinationPath, $filename);

			if ($uploadSuccess)
			{
				Image::make($destinationPath . $filename)
				->resize(150, null, function($constraint) {
					$constraint->aspectRatio();
				})
				->save($destinationPath . "thumbnail_" . $filename);

				$file = new TrainingFile();
				$file->training_id = $id;
				$file->url = $destinationPath . $filename;
				$file->name = $fileRealName;
				$file->thumbnail_url = $destinationPath . "thumbnail_" . $filename;
				$file->save();

				$url = asset($file->thumbnail_url);
				return Response::view('partials.single-image', compact('file'))->header('Content-Type', 'application/json');
			}
		}

		return Response::json(['message' => $fileRealName . ' - ' . $error], 400);
	}

	/**
	 * Delete the training file
	 * 
	 * @param  int
	 * @return Response
	 */
	public function destroyTrainingFile($id)
	{
		$file = TrainingFile::findOrFail($id);
		//Deleting the real files
		File::delete($file->url, $file->thumbnail_url);
		//Deleting from database
		$file->delete();

		return Response::json('success', 200);
	}

	/**
	 * Searching trainings by keywords and tags, returning search result
	 * 
	 * @param  
	 * @return Response
	 */
	public function search()
	{
		$tags = Request::input('tag_list');
		if (empty($tags)) {
			return Response::json('empty', 400);
		}
		$realTags = array();
		$userKeywords = array();

		//Separating already existing tags from user keywords
		foreach ($tags as $key => $tag){
			if (is_numeric($tag) && Tag::find($tag)) {
				$realTags[] = $tag;
			}
			else {
				$userKeywords[] = $tag;
			}
		}

		$trainings = Training::tagsSearch($realTags)->keywordSearch($userKeywords)->get();

		return view('partials.trainings-list', compact('trainings'));
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
	private function syncTags(Training $training, array $tags)
	{
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
	 * Save training to database
	 * 
	 * @param  TrainingRequest $request
	 * @return Training
	 */
	private function createTraining(TrainingRequest $request)
	{
		$training = new Training($request->all());
		Auth::user()->trainings()->save($training);

		$tags = array();

		if ($request->input('tag_list'))
		{
			$tags = $request->input('tag_list');
		}

		$this->syncTags($training, $tags);

		return $training;
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

	/**
	 * Verify the file size and type for the image
	 * @param  $fileObject [file received from the input]
	 * @return [boolean]             [true if image is legit]
	 */
	private function verifyImageFile($fileObject)
	{
		$error = "";

		if (!strcmp(explode("/", $fileObject->getMimeType())[0], "image") == 0)
		{
			$error .= "Vale failitüüp. ";
		}
		elseif ($fileObject->getSize() > 3000000)
		{
			$error .="Fail üle 3MB. ";
		}
		return $error;
	}


	/**
	 * Determine which notification to add and then add it
	 * @param [boolean] $oldStatus [previous status of training]
	 * @param [training] $training  [edited training]
	 */
	private function addNotifications($oldStatus, $training) {
		$title = '';
		$message = '';

		if (!$oldStatus && $training->confirmed)
		{
			$title = 'Treening kinnitatud!';
			$message = 'Administraator kinnitas teie treeningu: '. $training->title . '.';
		}
		elseif ($oldStatus && !$training->confirmed)
		{
			$title = 'Treeningut muudetud!';
			$message = 'Administraator eemaldas teie treeningult kinnituse: '. $training->title . '.';
		}
		else {
			$title = 'Treeningut muudetud!';
			$message = 'Administraator muutis teie treeningut: '. $training->title . '.';
		}

		$this->notificationsRepo->create($training->user()->first(), $title, $message);
	}

}
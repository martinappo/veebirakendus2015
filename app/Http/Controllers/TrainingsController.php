<?php namespace App\Http\Controllers;

use App\Training;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use Request;

class TrainingsController extends Controller {

	public function index() {

		$trainings = Training::latest()->confirmed()->get();

		return view('trainings.index', compact('trainings'));
	}

	public function create() {
		return view('trainings.create');
	}

	public function store(Requests\CreateTrainingRequest $request) {
		$input = $request->all();

		if (Auth::user()) {
			$user_id = Auth::user()->id;
		}

		$input['user_id'] = $user_id;
		$input['confirmed'] = true;
		Training::create($input); 

		return redirect('trainings');
	}

}

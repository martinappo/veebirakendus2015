<?php namespace App\Http\Controllers;

use App\Training;
use App\Http\Requests;
use App\Http\Requests\TrainingRequest;
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

	public function store(TrainingRequest $request) {

		$training = new Training($request->all());
		$training->confirmed = true;
		Auth::user()->trainings()->save($training);

		return redirect('trainings');
	}

	public function edit($id) {

		$training = Training::findOrFail($id);

		return view('trainings.edit', compact('training'));
	}

	public function update($id, TrainingRequest $request) {

		$training = Training::findOrFail($id);
		$training->update($request->all());

		return redirect('trainings');
	}

}

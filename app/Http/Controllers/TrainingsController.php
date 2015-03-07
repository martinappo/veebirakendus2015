<?php namespace App\Http\Controllers;

use App\Training;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TrainingsController extends Controller {

	public function index() {

		$trainings = Training::all();

		return view('trainings.index', compact('trainings'));
	}

}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TrainingsController extends Controller {

	public function index() {
		$trainings = ['trenn,' , 'trenn12', 'trenn23'];

		return view('trainings.index', compact('trainings'));
	}

}

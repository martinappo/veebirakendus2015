<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TrainingRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => 'required|min:3',
			'aadress' => 'required',
			'tag_list' => 'stringSelect',
		];
	}

	public function messages () 
	{
		$array = array(
			'title.required' => 'Pealkirja väli on kohustuslik ning peab olema vähemalt 3 märki.',
			'aadress.required' => 'Aadressi sisestamine on kohustuslik.',
			'tag_list.string_select' => 'Märksõna ei tohi koosneda ainult numbritest',
		);

		return $array;
	}

}

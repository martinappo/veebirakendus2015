<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginFormRequest extends Request {

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
			'email' => 'required|email',
			'password' => 'required'
		];
	}

	public function messages () 
	{
		$array = array(
			'email.required' => 'E-mail on kohustuslik.',
			'email.email' => 'E-mail on vales formaadis.',
			'password.required' => 'Parooli väli on kohustuslik.',
		);

		return $array;
	}

}

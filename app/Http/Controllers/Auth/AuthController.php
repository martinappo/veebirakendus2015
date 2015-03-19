<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\LoginFormRequest;
use App\User;
use Auth;
use Request;
use Socialize;
use Redirect;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Custom authentication with password and email
	 * If authentication succeeded, redirects
	 * 
	 * @return void
	 */
	public function authenticate(LoginFormRequest $request)
	{
		if (Auth::attempt(['email' => Request::get('email'), 'password' => Request::get('password')]))
		{
			session()->flash('flash_message', 'Sisse logitud!');
			return response()->json(['success' => 'true', 'redirect' => 'home'], 200);
		}

		return response()->json(['success' => 'false', 'message' => 'Parool ja e-mail ei klapi.']);
	}

	/**
	 * Redirecting to social login
	 * @param  String $provider [either facebook or google]
	 * @return void
	 */
	public function redirectToProvider($provider)
	{
		return Socialize::with($provider)->redirect();
	}

	/**
	 * Function is handling social media response
	 * 
	 * @param  String $provider [either facebook or google]
	 * @return void
	 */
	public function handleProviderCallback($provider)
	{
		$user = Socialize::with($provider)->user();
		$socialId = $user->getId();

		if ($this->authenticateWith($provider, $socialId))
		{
			session()->flash('flash_message', 'Sisse logitud!');
			return redirect('home');
		}
		else
		{
			$this->registerWith($provider, $user);
			session()->flash('flash_message', 'Teie kasutaja on edukalt loodud!');
			return redirect('home');
		}

	}

	/* ======================================= Private functions =================================== */

	/**
	 * Authenticating with social id
	 * @param  String $provider
	 *         [Which social service are we using]
	 *         String $socialId [User social id]
	 * @return boolean
	 */
	private function authenticateWith($provider, $socialId)
	{
		$socialIdVar = '';
		switch ($provider)
		{
			case 'facebook':
				$socialIdVar = 'fb_id';
				break;
			case 'google':
				$socialIdVar = 'g_id';
				break;
		}

		$userFromDb = User::where($socialIdVar, $socialId)->first();
		if ($userFromDb)
		{
			Auth::loginUsingId($userFromDb->id);
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Registering user with social provider
	 * 
	 * @param  String $provider [Facebook or Google]
	 * @param  $user [User instance from fb or g]
	 * @return void
	 */
	private function registerWith($provider, $user)
	{
		$socialIdVar = '';
		switch ($provider)
		{
			case 'facebook':
				$socialIdVar = 'fb_id';
				break;
			case 'google':
				$socialIdVar = 'g_id';
				break;
		}

		$newUser = User::firstOrNew(['email' => $user->getEmail()]);
		$newUser->$socialIdVar = $user->getId();
		$newUser->name = $user->getName();
		$newUser->email = $user->getEmail();
		$newUser->save();
		Auth::loginUsingId($newUser->id);
		return;
	}


}

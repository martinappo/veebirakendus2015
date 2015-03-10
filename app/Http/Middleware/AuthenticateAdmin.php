<?php namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if ( ! $request->user()->isAdmin() ) {

			if ($request->ajax()) {
				return response('Õigused puuduvad.', 401);
			}
			else {
				session()->flash('flash_message', 'Sul ei ole õigusi sellele lehele minekuks.');
				return redirect('/');
			}

		}

		return $next($request);
	}

}
